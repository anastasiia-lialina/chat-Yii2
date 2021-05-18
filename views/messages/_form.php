<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \app\models\Messages */
/* @var $form yii\widgets\ActiveForm */
/* @var $answer boolean */
?>

<?php
//todo переметить в отдельный файл
$this->registerJs(
'$("document").ready(function(){
        $("#new_message").on("pjax:end", function() {
            $.pjax.reload({container:"#messages"});
        });
    });'
);
?>

<div class="send-wrap">
    <?php yii\widgets\Pjax::begin(['id' => 'new_message']) ?>

    <?php $form = ActiveForm::begin([
        'options' => [
            'data-pjax' => true,
        ]]);
    ?>

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
    <?php Pjax::end(); ?>

</div>