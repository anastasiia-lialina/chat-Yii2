<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Messages;
use app\models\search\MessagesSearch;

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
                'only' => ['toggle-ban' , 'banned-messages'],
                'rules' => [
                    [
                        'actions' => ['toggle-ban'],
                        'allow' => true,
                        'roles' => ['banMessage', 'unbanMessage'],
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

        if ($model->load(Yii::$app->request->post()) && Yii::$app->user->can('sendMessage')) {
            if($model->save()){
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
     * Блокировка сообщений
     * @param int $id
     */
    public function actionBanMessage(int $id)
    {
        $model = Messages::findOne($id);

        if ($model->toggleBan(false)) {
            $this->goBack();
        }
    }

    /**
     * Разблокировка сообщений
     * @param $id
     */
    public function actionUnbanMessage($id)
    {
        $model = Messages::findOne($id);

        if ($model->toggleBan(true))
        {
            $this->redirect('banned-messages');
        }

    }

    /**
     * Список заблокированных сообщения
     * @return string
     */
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
