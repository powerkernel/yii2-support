<?php

/* @var $this yii\web\View */
/* @var $model \modernkernel\support\models\Content */

?>
<div itemscope="" itemtype="http://schema.org/EmailMessage">
    <div itemprop="potentialAction" itemscope="" itemtype="http://schema.org/ViewAction">
        <link itemprop="target" href="<?= $model->ticket->getUrl(true) ?>">
        <meta itemprop="name" content="<?= Yii::$app->getModule('support')->t('View Ticket') ?>">
    </div>
    <meta itemprop="description" content="<?= Yii::$app->getModule('support')->t('{APP}: Ticket #{ID} updated', ['APP'=>Yii::$app->name, 'ID'=>$model->ticket->id]) ?>">
</div>

<table class="body-wrap" style="background-color: #f6f6f6; width: 100%;" width="100%" bgcolor="#f6f6f6">
    <tr>
        <td style="vertical-align: top;" valign="top"></td>
        <td class="container" width="600" style="vertical-align: top; display: block !important; max-width: 600px !important; margin: 0 auto !important; clear: both !important;" valign="top">
            <div class="content" style="max-width: 600px; margin: 0 auto; display: block; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0" style="background-color: #fff; border: 1px solid #e9e9e9; border-radius: 3px;" bgcolor="#fff">
                    <tr>
                        <td class="content-wrap" style="vertical-align: top; padding: 20px;" valign="top">

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block" style="vertical-align: top; padding: 0 0 20px;" valign="top">
                                        <?= Yii::$app->getModule('support')->t('Ticket #{ID}: New reply from {NAME}:', ['ID'=>$model->ticket->id, 'NAME'=>!empty($model->created_by)?$model->createdBy->fullname:Yii::$app->getModule('ticket')->t('Ticket System')]) ?>
                                    </td>
                                </tr>


                                <tr>
                                    <td class="content-block" style="vertical-align: top; padding: 0 0 20px;" valign="top">
                                        <?= Yii::$app->formatter->asNtext($model->content) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="content-block aligncenter" colspan="2" style="vertical-align: top; padding: 0 0 20px; text-align: center;" valign="top" align="center">
                                        <a href="<?= $model->ticket->getUrl(true) ?>" class="btn-primary" style="font-weight: bold; color: #FFF; background-color: #348eda; border: solid #348eda; border-width: 10px 20px; line-height: 2em; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize;"><?= Yii::$app->getModule('support')->t('View Ticket') ?></a>
                                    </td>
                                </tr>



                            </table>
                        </td>
                    </tr>
                </table>

            </div>

        </td>
        <td style="vertical-align: top;" valign="top"></td>
    </tr>
</table>
