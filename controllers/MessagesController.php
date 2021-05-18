<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\swiftmailer\Message;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Messages;
use app\models\search\MessagesSearch;
use yii\web\HttpException;

class MessagesController extends Controller
{

    /**
     * @return array[]
     */
    public function behaviors() : array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'toggle-ban' , 'banned-messages'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['toggle-ban'],
                        'allow' => true,
                        'roles' => ['banMessage'],
                    ],
                    [
                        'actions' => ['banned-messages'],
                        'allow' => true,
                        'roles' => ['viewBannedMessages'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Вывод сообщений и добавление нового
     * @return string
     */
    public function actionIndex() : string
    {
        $model = new Messages();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model = new Messages();
            }
        }

        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * @param int $id
     * @param bool $visible
     */
    public function actionToggleBan(int $id, bool $visible)
    {
        $model = Messages::findOne($id);
        $model->is_visible = $visible;

        if ($model->save()) {
            $this->goBack();
        }
    }

    public function actionBannedMessages()
    {

        $searchModel = new MessagesSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('is_visible = false');

        return $this->render('banned', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
