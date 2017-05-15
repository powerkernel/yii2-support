<?php
/**
 * @author Harry Tang <harry@modernkernel.com>
 * @link https://modernkernel.com
 * @copyright Copyright (c) 2016 Modern Kernel
 */

use modernkernel\support\models\Cat;
use yii\helpers\Html;
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('support', 'Create') : Yii::t('support', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
