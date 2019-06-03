<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Vacations;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VacationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vacations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacations-index">
    <div class="row">
        <div class="col-sm-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a(Yii::t('app', 'Create Vacations'), ['create-vac'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'begin',
                        'options' => [
                            'class' => 'col-sm-1',
                        ]
                    ],
                    [
                        'attribute' => 'end',
                        'options' => [
                            'class' => 'col-sm-1',
                        ]
                    ],
                    [
                        'header' => Yii::t('user', 'Confirmation'),
                        'value' => function ($model) {
                            if ($model->status == Vacations::SUBMITTED) {
                                return Html::a(Yii::t('app', 'Confirm'), ['confirm', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success btn-inline-block col-sm-6',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('app', 'Are you sure you want to confirm this request?'),
                                ]) . "  " . Html::a(Yii::t('app', 'Reject'), ['reject', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-danger btn-inline-block col-sm-6',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('app', 'Are you sure you want to confirm this request?'),
                                ]);
                            } elseif ($model->status == Vacations::CONFIRMED) {
                                return '<div class="text-center">
                                            <span class="text-success">' . Yii::t('app', 'Confirmed') . '</span>
                                        </div>';
                            } else {
                                return '<div class="text-center">
                                            <span class="text-success">' . Yii::t('app', 'Rejected') . '</span>
                                        </div>';
                            }
                        },
                        'format' => 'raw',
                        'filter' => Html::activeDropDownList($searchModel, 'status', ['0' => 'Pateikta', '1' => 'Patvirtinta', '2' => 'Atmesta'], 
                        ['class'=>'form-control','prompt' => Yii::t('app', 'Select status')]),
                        'options' => [
                            'class' => 'col-sm-2',
                        ]

                        /*'attribute' => 'status',
                        'filter' => Html::activeDropDownList($searchModel, 'status', ['0' => 'Pateikta', '1' => 'Patvirtinta', '2' => 'Atmesta'], 
                        ['class'=>'form-control','prompt' => Yii::t('app', 'Select status')]),
                        'options' => [
                            'class' => 'col-sm-2',
                        ]*/
                    ],
                    [
                        'attribute' => 'created_at',
                        'options' => [
                            'class' => 'col-sm-2',
                        ]
                    ], 
                    [
                        'label' => 'Darbuotojas',
                        'attribute' => 'fkUser',                        
                        'value' => 'fkUser.profile.name',
                        'options' => [
                            'class' => 'col-sm-3',
                        ]
                    ],
                    [
                        'attribute' => 'confirmed_at',
                        'options' => [
                            'class' => 'col-sm-2',
                        ]
                    ], 
                    //'fk_admin',

                    ['class' => 'yii\grid\ActionColumn', 'template' => '{update}',
                     'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            //$url ='index.php?r=client-login/lead-view&id='.$model->id;
                            return \yii\helpers\Url::to(['update-vac', 'id' => $model->id]);
                        }
                    },                    
                    'buttons' => [
                        'update' => function ($url, $model) {
                            if ($model->status > 0) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update'),]);
                            } else
                                return "";
                        }
                    ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>    
</div>
