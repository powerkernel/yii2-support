<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */

use powerkernel\fontawesome\Icon;
use powerkernel\support\models\Ticket;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model powerkernel\support\models\Ticket */
/* @var $reply powerkernel\support\models\Content */

$this->params['breadcrumbs'][] = ['label' => Yii::t('support', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/* misc */
//$js=file_get_contents(__DIR__.'/index.min.js');
//$this->registerJs($js);
//$css=file_get_contents(__DIR__.'/index.css');
//$this->registerCss($css);
?>
<div class="ticket-view">
    <div class="box box-info">
        <div class="box-header with-border">
            <h1 class="box-title">&num;<?= $model->id ?> <?= $model->title ?>
                <small style="margin-left: 10px"><?= $model->category->title ?></small>
            </h1>

            <div class="pull-right">
                <?= Yii::$app->getModule('support')->t('Status: {STATUS}', ['STATUS' => $model->getStatusColorText()]) ?>
            </div>

        </div>
        <div class="box-body">
            <ul class="timeline timeline-inverse">
                <?php foreach ($model->contents as $post) : ?>
                    <li>
                        <?php if (empty($post->created_by)): ?>
                            <?= Icon::widget(['icon' => 'info-circle bg-aqua']) ?>
                        <?php else: ?>
                            <?= Icon::widget(['icon' => $post->created_by == $model->created_by ? 'comments bg-blue' : 'comments bg-orange']) ?>
                        <?php endif; ?>

                        <div class="timeline-item">
                            <span class="time"><?= Icon::widget(['icon' => 'clock-o']) ?> <?= Yii::$app->formatter->asDatetime($post->createdAt) ?></span>
                            <h3 class="timeline-header"><?= !empty($post->created_by) ? $post->createdBy->fullname : Yii::$app->getModule('support')->t('Ticket System') ?></h3>
                            <div class="timeline-body">
                                <?= Yii::$app->formatter->asNtext($post->content) ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <li>
                    <?= Icon::widget(['icon' => 'clock-o']) ?>
                </li>
            </ul>


            <div style="padding-top: 10px">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($reply, 'content')->textarea(['rows' => 8])->label(false) ?>
                <div class="form-group">
                    <?= \common\components\SubmitButton::widget(['text'=>Yii::t('support', 'Reply'), 'options'=>['class' => 'btn btn-primary']]) ?>
                    <?php if($model->status!=Ticket::STATUS_CLOSED):?>
                    <?= Html::a(Yii::t('support', 'Close'), ['close', 'id' => is_a($model, '\yii\mongodb\ActiveRecord')?(string)$model->_id:$model->id], ['class' => 'btn btn-warning']) ?>
                    <?php endif;?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
