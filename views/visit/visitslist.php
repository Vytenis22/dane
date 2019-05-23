<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Visits');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-index">

    <div class="row">
        <div class="col-sm-11">

        <h1 style="margin-top: 0px"><?= Html::encode($this->title) ?></h1>
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
    		'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'reg_nr',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                //'name',
                [
                    'attribute' => 'start_time',
                    'options' => [
                        'class' => 'col-sm-2',
                    ]
                ],
                //'surname',
                [
                    'attribute' => 'end',
                    'options' => [
                        'class' => 'col-sm-2',
                    ]
                ],
                [
                    'attribute' => 'room',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                [
                    'attribute' => 'info',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                [
                    'attribute' => 'total_price',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                [
                    'label' => 'Gydytojas',
                    'attribute' => 'user',
                    'value' => 'user.profile.name',
                    'options' => [
                        'class' => 'col-sm-2',
                    ]
                ],
                [
                    'label' => 'Pacientas',
                    'attribute' => 'patient',
                    'value' => function ($model) {
                        return $model->patient->name . " " . $model->patient->surname;
                    },
                    'options' => [
                        'class' => 'col-sm-2',
                    ]
                ],
                //'id_Patient',
    			//'Count' => $patient->patients(),	
            ],
        ]); 
    	?>

        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
