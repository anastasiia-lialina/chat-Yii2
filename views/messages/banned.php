<?php

use app\models\search\MessagesSearch;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View
* @var $searchModel MessagesSearch;
* @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('common', 'Blocked messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="models-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'attribute' => 'date',
                'filter' => kartik\daterange\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'startAttribute' => 'from_date',
                    'endAttribute' => 'to_date',
                    'pluginOptions' => [
                        'timePicker' => true,
                        'locale' => [
                            'cancelLabel' => 'Clear',
                            'format' => 'DD.MM.YYYY HH:mm:SS'
                        ],
                    ]
                ])
            ],
            'text:ntext',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{unban-message}',
                'buttons' => [
                    'unban-message' => function ($url) {
                        return Html::a(
                                Yii::t('common', 'Unblock'),
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
