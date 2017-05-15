<?php
/* @var $this yii\web\View */
/* @var $model \modernkernel\ticket\models\Content */
?>

<?= Yii::$app->getModule('ticket')->t('Ticket #{ID}: New reply from {NAME}:', ['ID'=>$model->ticket->id, 'NAME'=>!empty($model->created_by)?$model->createdBy->fullname:Yii::$app->getModule('ticket')->t('Ticket System')]) ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>


<?= Yii::$app->getModule('ticket')->t('View Ticket: {URL}', ['URL'=>$model->ticket->getUrl(true)]) ?>