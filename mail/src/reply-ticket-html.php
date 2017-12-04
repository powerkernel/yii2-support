<?php

/* @var $this yii\web\View */
/* @var $model \powerkernel\support\models\Content */

?>
<div itemscope itemtype="http://schema.org/EmailMessage">
    <div itemprop="potentialAction" itemscope itemtype="http://schema.org/ViewAction">
        <link itemprop="target" href="<?= $model->ticket->getUrl(true) ?>"/>
        <meta itemprop="name" content="<?= Yii::$app->getModule('support')->t('View Ticket') ?>"/>
    </div>
    <meta itemprop="description" content="<?= Yii::$app->getModule('support')->t('{APP}: Ticket #{ID} updated', ['APP'=>Yii::$app->name, 'ID'=>$model->ticket->id]) ?>"/>
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
                                        <?= Yii::$app->getModule('support')->t('Ticket #{ID}: New reply from {NAME}:', ['ID'=>$model->ticket->id, 'NAME'=>!empty($model->created_by)?$model->createdBy->fullname:Yii::$app->getModule('support')->t('Ticket System')]) ?>
                                    </td>
                                </tr>


                                <tr>
                                    <td class="content-block">
                                        <?= Yii::$app->formatter->asNtext($model->content) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="content-block aligncenter" colspan="2">
                                        <a href="<?= $model->ticket->getUrl(true) ?>" class="btn-primary"><?= Yii::$app->getModule('support')->t('View Ticket') ?></a>
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