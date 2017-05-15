<?php

use modernkernel\ticket\models\Cat;
use modernkernel\ticket\models\Ticket;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel modernkernel\ticket\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


/* breadcrumbs */
$this->params['breadcrumbs'][] = $this->title;

/* misc */
$this->registerJs('$(document).on("pjax:send", function(){ $(".grid-view-overlay").removeClass("hidden");});$(document).on("pjax:complete", function(){ $(".grid-view-overlay").addClass("hidden");})');
//$js=file_get_contents(__DIR__.'/index.min.js');
//$this->registerJs($js);
//$css=file_get_contents(__DIR__.'/index.css');
//$this->registerCss($css);
?>
<div class="ticket-index">
    <div class="box box-primary">
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php Pjax::begin(); ?>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],

                        'id',
                        ['attribute' => 'cat', 'value' => function ($model) {
                            return $model->category->title;
                        }, 'filter' => Cat::getCatList()],
                        'title',
                        //'status',
                        //'created_by',
                        // 'created_at',
                        // 'updated_at',

                        //['attribute' => 'created_by', 'value' => function ($model){return $model->createdBy->fullname;}],
                        ['attribute' => 'status', 'value' => function ($model){return $model->statusColorText;}, 'filter'=> Ticket::getStatusOption(), 'format'=>'raw'],
                        [
                            'attribute' => 'created_at',
                            'value' => 'created_at',
                            'format' => 'dateTime',
                            'filter' => DatePicker::widget(['model' => $searchModel, 'attribute' => 'created_at', 'dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]),
                            'contentOptions' => ['style' => 'min-width: 80px']
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}'
                        ],

                    ],
                ]); ?>
            </div>
            <?php Pjax::end(); ?>
            <p>
                <?= Html::a(Yii::t('ticket', 'Open Ticket'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>

        </div>
        <!-- Loading (remove the following to stop the loading)-->
        <div class="overlay grid-view-overlay hidden">
            <?= \modernkernel\fontawesome\Icon::widget(['icon' => 'refresh fa-spin']) ?>
        </div>
        <!-- end loading -->
    </div>
</div>
