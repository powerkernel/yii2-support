<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \modernkernel\ticket\models\Ticket */
?>

<?= Yii::$app->getModule('ticket')->t('Hello Admin,') ?>

<?= Yii::$app->getModule('ticket')->t('{USER} ({EMAIL}) have opened a ticket with the following message:', [
        'USER' => Html::encode($model->createdBy->fullname),
        'EMAIL' => Html::encode($model->createdBy->email)]) ?>


<?= $model->title ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>



<?= Yii::$app->getModule('ticket')->t('View Ticket: {URL}', ['URL'=>$model->getUrl(true)]) ?>