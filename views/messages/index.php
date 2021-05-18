<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model Messages
 * @var $searchModel MessagesSearch
 */

use app\models\Messages;
use app\models\search\MessagesSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\grid\GridView;

?>
<h1>Чат</h1>

<div class="container">
    <div class="row">
        <div class="message-wrap col-lg-6 col-lg-offset-3">
            <div class="msg-wrap">
                <?php Pjax::begin(['id' => 'messages']) ?>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_chatItem',
                    'layout'=>"{items}"
                ]);
                ?>
                <?php Pjax::end() ?>
            </div>
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= $this->render('_form',[
                    'model' => $model,
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
