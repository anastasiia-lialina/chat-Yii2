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
            /*['attribute' => 'author',
                'label' => 'Автор',
                'value' => function($model) {
                    return $model->user->username;
                }
            ],*/
            'user.username',
            'text:ntext',
        ],
    ]); ?>
</div>
