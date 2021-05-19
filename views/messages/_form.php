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
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')
             ->textarea([
                 'rows' => 3,
                 'class' => "form-control send-message",
             ])
             ->label('Введите сообщение');
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Отправить') , ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>