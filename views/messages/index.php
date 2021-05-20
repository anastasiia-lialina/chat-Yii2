<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model Messages
 * @var $searchModel MessagesSearch
 */

use app\models\Messages;
use app\models\search\MessagesSearch;
use yii\widgets\ListView;

?>
<h1><?= Yii::t('common', 'Chat') ?></h1>

<div class="container">
    <div class="row">
        <div class="message-wrap col-lg-6 col-lg-offset-3">
            <div class="msg-wrap">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_chatItem',
                    'layout'=>"{items}"
                ]);
                ?>
            </div>
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= $this->render('_form',[
                    'model' => $model,
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
