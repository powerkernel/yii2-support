<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \powerkernel\support\models\Ticket */
?>

<?= Yii::$app->getModule('support')->t('Hello Admin,') ?>

<?= Yii::$app->getModule('support')->t('{USER} ({EMAIL}) have opened a ticket with the following message:', [
        'USER' => Html::encode($model->createdBy->fullname),
        'EMAIL' => Html::encode($model->createdBy->email)]) ?>


<?= $model->title ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>



<?= Yii::$app->getModule('support')->t('View Ticket: {URL}', ['URL'=>$model->getUrl(true)]) ?>