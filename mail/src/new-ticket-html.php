<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

/* @var $model \modernkernel\support\models\Ticket */

?>
<div itemscope itemtype="http://schema.org/EmailMessage">
    <div itemprop="potentialAction" itemscope itemtype="http://schema.org/ViewAction">
        <link itemprop="target" href="<?= $model->getUrl(true) ?>"/>
        <meta itemprop="name" content="<?= Yii::$app->getModule('support')->t('View Ticket') ?>"/>
    </div>
    <meta itemprop="description" content="<?= Yii::$app->getModule('support')->t('You\'ve received a ticket (#{ID}) from {APP}', ['ID'=>$model->id, 'APP'=>Yii::$app->name]) ?>"/>
</div>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        <?= Yii::$app->getModule('support')->t('Greetings from {APP},', ['APP'=>Yii::$app->name]) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <?= Yii::$app->getModule('support')->t('{USER} ({EMAIL}) have opened a ticket with the following message:', [
                                            'USER' => Html::encode($model->createdBy->fullname),
                                            'EMAIL' => Html::encode($model->createdBy->email)]) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="content-block">
                                        <?= Yii::$app->getModule('support')->t('Ticket #{ID}', ['ID'=>$model->id]) ?><br>
                                        <?= Yii::$app->getModule('support')->t('Subject: {TITLE}', ['TITLE'=>$model->title]) ?><br>
                                        <?= Yii::$app->formatter->asNtext($model->content) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="content-block aligncenter" colspan="2">
                                        <a href="<?= $model->getUrl(true) ?>" class="btn-primary"><?= Yii::$app->getModule('support')->t('View Ticket') ?></a>
                                    </td>
                                </tr>



                            </table>
                        </td>
                    </tr>
                </table>

            </div>

        </td>
        <td></td>
    </tr>
</table>
<link href="src/css/mailgun.css" media="all" rel="stylesheet" type="text/css" />