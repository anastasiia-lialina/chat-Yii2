<?php

use app\models\search\MessagesSearch;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View
* @var $searchModel MessagesSearch;
* @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Заблокированные сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="models-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'user.username',
            'text:ntext',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{unban-message}',
                'buttons' => [
                    'unban-message' => function ($url) {
                        return Html::a(
                            'Разблокировать',
                            $url,
                            [
                                'data'  => [
                                    'pjax'  => 0,
                                    'method'     => 'post',
                                ],
                            ]
                        );
                    },
                ]
            ]
        ],
    ]); ?>
</div>
