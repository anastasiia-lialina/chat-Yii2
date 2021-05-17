<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var \app\models\Messages $messages
 */

?>
<h1>Сообщения</h1>
<?php
    foreach($messages as $message){
        echo $message->text;
    }
?>