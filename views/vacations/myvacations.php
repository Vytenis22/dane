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

            <?php if (Yii::$app->session->hasFlash('unavailableVacations')): ?>
                <p class="papr">
                    <?= Html::a(Yii::t('app', 'Return'), ['my-vacations'], ['class' => 'btn btn-primary']) ?> 
                </p> 
                <div class="alert alert-danger col-sm-8">
                    Pasirinkite laikotarpį, į kurį nepatenka jau patvirtintų atostogų dienos.
                </div>           
            <?php else: ?>

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a(Yii::t('app', 'Create Vacations'), ['create'], ['class' => 'btn btn-success']) ?>
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
                        'header' => Yii::t('app', 'Status'),
                        'value' => function ($model) {
                            if ($model->status == Vacations::SUBMITTED) {
                                return '<div class="text-center">
                                            <span class="text-primary">' . Yii::t('app', 'Submitted') . '</span>
                                        </div>';
                            } elseif ($model->status == Vacations::CONFIRMED) {
                                return '<div class="text-center">
                                            <span class="text-success">' . Yii::t('app', 'Confirmed') . '</span>
                                        </div>';
                            } else {
                                return '<div class="text-center">
                                            <span class="text-danger">' . Yii::t('app', 'Rejected') . '</span>
                                        </div>';
                            }
                        },
                        'format' => 'raw',
                        'filter' => Html::activeDropDownList($searchModel, 'status', ['0' => 'Pateikta', '1' => 'Patvirtinta', '2' => 'Atmesta'], 
                        ['class'=>'form-control','prompt' => Yii::t('app', 'Select status')]),
                        'options' => [
                            'class' => 'col-sm-2',
                        ]
                    ],
                    [
                        'attribute' => 'created_at',
                        'options' => [
                            'class' => 'col-sm-2',
                        ]
                    ],                    
                    //'fk_admin',
                    [
                        'label' => 'Patvirtino',
                        'attribute' => 'fkAdmin',
                        'value' => 'fkAdmin.profile.name',
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

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if ($model->status == Vacations::SUBMITTED) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update'),]);
                                } else
                                    return "";
                            },
                            'delete' => function ($url, $model) {
                                if ($model->status == Vacations::SUBMITTED) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('app', 'Delete'),
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this request?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                                } else
                                    return "";
                            }
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>

            <?php endif; ?>
        </div>
    </div>    
</div>
