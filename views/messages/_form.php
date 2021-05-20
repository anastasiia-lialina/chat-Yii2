<?php

use app\models\Messages;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Messages */
/* @var $form yii\widgets\ActiveForm */
/* @var $answer boolean */
?>

<div class="send-wrap">
    <?php $form = ActiveForm::begin(['id' => 'send-message-form']); ?>

    <?= $form->field($model, 'text')
             ->textarea([
                 'rows' => 3,
                 'class' => "form-control send-message",
             ])
             ->label(Yii::t('common', 'Message'));
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Send') , ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>