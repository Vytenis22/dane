<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

?>
    <?php
    $navWidget = Nav::widget([
        'items' => [
            [
                'label' => 'Papildomai',
                'items' => [
                     ['label' => Yii::t('app', 'Service Assignments'), 'url' => Url::to(['/service-assignment/index'])],
                     '<li class="divider"></li>',
                     ['label' =>  Yii::t('app', 'Service Categories'), 'url' => Url::to(['/service-category/index'])],
                ],
            ],
        ],
        'options' => ['class' =>'nav navbar-nav pull-right'],
    ]);
?>
<div class="row">
    <div class="col-sm-8">

                <div class="assignments">
                    <?= /*Html::a(Yii::t('app', 'Service Assignments'), Url::to(['service-assignment/index']), ['class' => 'btn btn-primary']);*/
                        $navWidget;
                    ?>
                </div>
    </div>
</div>



<?php


/* @var $this yii\web\View */
/* @var $searchModel app\models\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Services');
$this->params['breadcrumbs'][] = $this->title;
    ?>
<div class="services-index">
    <div class="row">

        <div class="col-sm-8">

        <h1 class="services-heading"><?= Html::encode($this->title) ?></h1>
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="buttons">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Create Services'), ['create'], ['class' => 'btn btn-success']) ?>

                <!-- <div class="assignments"> -->
                    <!-- <?= Html::a(Yii::t('app', 'Service Assignments'), Url::to(['service-assignment/index']), ['class' => 'btn btn-primary']);

                        $navWidget;
                    ?> -->
                <!-- </div> -->
            </p>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{summary}\n{items}\n<div align='center'>{pager}</div>",
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                /*[
                    'attribute' => 'id',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],*/
                //'id',
                //'name',
                [
                    'label' => 'Pavadinimas',
                    'attribute' => 'name',
                    'options' => [
                        'class' => 'col-sm-7',
                    ],
                ],
                //'parent_id',
                [
                    'label' => 'Kategorija',
                    'attribute' => 'category',
                    'value' => 'category.parent_name',
                    'options' => [
                        'class' => 'col-sm-2',
                    ]
                ],
                [
                    'attribute' => 'price',
                    'label' => Yii::t('app', 'Price'),
                    'options' => [
                            'class' => 'col-sm-1',
                        ],       
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>

        </div>
    </div>
</div>
