<?php

namespace app\controllers;

use yii\filters\AccessControl;
use app\models\Messages;
use yii\data\ActiveDataProvider;

class MessagesController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $messages = Messages::find()->orderBy('created_at')->all();

        return $this->render('index', [
            'messages' => $messages,
        ]);
    }

}
