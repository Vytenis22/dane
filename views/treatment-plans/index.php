<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TreatmentPlansSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['patient/view', 'id' => $id_Patient]), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = $model->name . " " . $model->surname . " " . Yii::t('app', 'treatment plans');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '{name}', ['name' => $model->fullName]), 'url' => Url::to(['patient/view', 'id' => $id_Patient])];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="treatment-plans-index">
    <div class="row">
        <div class="col-sm-7">

        <h2 style="padding-bottom: 10px;"><?= Html::encode($this->title) ?></h2>    
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= Html::a(Yii::t('app', 'Create Treatment Plans'), ['create', 'id_Patient' => $id_Patient], ['class' => 'btn btn-success', 'style' => ['margin-bottom' => '10px']]) ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'begin',
                [
                    'attribute' => 'begin',
                    'options' => [
                            'class' => 'col-sm-1',
                        ],
                ],                    
                //'end',
                [
                    'attribute' => 'end',
                    'options' => [
                            'class' => 'col-sm-1',
                        ],
                ],
                //'info:ntext',
                [
                    'attribute' => 'info',
                    'options' => [
                            'class' => 'col-sm-4',
                        ],
                ],
                /* nereikia rusiuoti pagal pacienta
                [
                    'label' => 'Pacientas',
                    'attribute' => 'patientFullName',
                    //'value' => 'patient.name',
                ],
                */
                [
                    'label' => 'Gydytojas',
                    'attribute' => 'user',
                    'value' => 'user.profile.name',
                    'options' => [
                            'class' => 'col-sm-3',
                        ],
                ],
                /*
                [
                    'attribute' => 'patientname',
                    'value' => 'patient.name',
                ],
                */
                //'fk_patient',

                ['class' => 'yii\grid\ActionColumn',
                 'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        //$url ='index.php?r=client-login/lead-view&id='.$model->id;
                        return \yii\helpers\Url::to(['view', 'id' => $model->id, 'id_Patient' => $model->fk_patient]);
                    }
                    if ($action === 'update') {
                        //$url ='index.php?r=client-login/lead-view&id='.$model->id;
                        return \yii\helpers\Url::to(['update', 'id' => $model->id, 'id_Patient' => $model->fk_patient]);
                    }
                    if ($action === 'delete') {
                        //$url ='index.php?r=client-login/lead-view&id='.$model->id;
                        return \yii\helpers\Url::to(['delete', 'id' => $model->id, 'id_Patient' => $model->fk_patient]);
                    }
                }
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
