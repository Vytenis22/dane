<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Patients');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-index">

    <div class="row">
        <div class="col-sm-11">

        <h1 style="margin-top: 0px"><?= Html::encode($this->title) ?></h1>
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <p>
            <?= \Yii::$app->user->can('manageVisits') ? Html::a(Yii::t('app', 'Create Patient'), ['create'], ['class' => 'btn btn-success']) : "" ?>
        </p>
    	
    	<!-- <p class="pull-right"><strong><?= "Iš viso pacientų: " . $dataProvider->getTotalCount(); ?></strong></p> -->
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
    		'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'card_number',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                //'name',
                [
                    'attribute' => 'name',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                //'surname',
                [
                    'attribute' => 'surname',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                [
                    'attribute' => 'code',
                    'options' => [
                        'class' => 'col-sm-1',
                    ],
                    'visible' => \Yii::$app->user->can('manageVisits'),
                ],
                'email:email',
                /*[
                    'attribute' => 'email',
                    'options' => [
                        'class' => 'col-lg-3',
                    ]
                ],*/
                //'phone',
                [
                    'attribute' => 'phone',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                //'sex',
                [
                    'attribute' => 'sex',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                //'birth_date',
                [
                    'attribute' => 'birth_date',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                [
                    'label' => 'Miestas',
                    'attribute' => 'cityObj',
                    'value' => 'cityName',
                    'options' => [
                        'class' => 'col-sm-1',
                    ]
                ],
                //'id_Patient',
    			//'Count' => $patient->patients(),	

                ['class' => 'yii\grid\ActionColumn', 'template' => \Yii::$app->user->can('manageVisits') ? '{view} {update} {delete}' : '{view}'],
            ],
        ]); 
    	
    	//echo "Is viso pacientu: " . $patient;
    	?>
    	
    	<?php
    	//echo "Iš viso pacientų: " . $dataProvider->getTotalCount();
    	
    	//echo "Is viso Pjax pacientu: " . (count($dataProvider));
    	
    	?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
