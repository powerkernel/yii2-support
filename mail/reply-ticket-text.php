<?php
/* @var $this yii\web\View */
/* @var $model \modernkernel\support\models\Content */
?>

<?= Yii::$app->getModule('support')->t('Ticket #{ID}: New reply from {NAME}:', ['ID'=>$model->ticket->id, 'NAME'=>!empty($model->created_by)?$model->createdBy->fullname:Yii::$app->getModule('support')->t('Ticket System')]) ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>


<?= Yii::$app->getModule('support')->t('View Ticket: {URL}', ['URL'=>$model->ticket->getUrl(true)]) ?>