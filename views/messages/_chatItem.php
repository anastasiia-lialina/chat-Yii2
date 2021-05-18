<?php
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
?>

<div class="media msg <?= $model->user->isAdmin() ? 'admin-msg': '' ?>">
    <div class="media-body">
        <small class="pull-right time"><i class="fa fa-clock-o"></i><?= date('d.m.Y H:m:i', $model->created_at) ?></small>
        <h5 class="media-heading"><?= Html::encode($model->user->username) ?></h5>
        <small class="col-lg-10"><?= $model->text ?></small>
    </div>
    <small class="pull-right">
        <?php
        if (Yii::$app->user->can('banMessage')) {
            if ($model->is_visible) {
                echo Html::a(
                    'Скрыть',
                    ['/messages/toggle-ban', 'id' => $model->id, 'visible' => false],
                    [
                        'data'  => [
                            'pjax'  => 0,
                            'confirm'    => 'Вы уверены, что хотите скрыть сообщение?',
                            'method'     => 'post',
                        ],
                    ]
                );
            } else {
                echo '<span class="label label-danger">Сообщение скрыто</span>';
            }
        }
        ?>
    </small>
</div>