<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */

use modernkernel\support\models\Cat;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modernkernel\support\models\Cat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Cat::getStatusOption()) ?>

    <div class="form-group">
        <?= \common\components\SubmitButton::widget(['text'=>$model->isNewRecord ? Yii::t('support', 'Create') : Yii::t('support', 'Update'), 'options'=>['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
