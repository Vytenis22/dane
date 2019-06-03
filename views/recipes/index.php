<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="return-button">
<?= \Yii::$app->user->can('viewVisit') ? Html::a(Yii::t('app', 'Return'), Url::to(['patient/view', 'id' => $id_Patient]), ['class' => 'btn btn-primary']) : Html::a(Yii::t('app', 'Return'), Url::to(['patient/view-patient', 'id' => \Yii::$app->user->id]), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = $model->name . " " . $model->surname . " " . Yii::t('app', 'Recipes');
\Yii::$app->user->can('viewVisit') ? $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']] : "";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '{name}', ['name' => $model->fullName]), 'url' => Url::to(['patient/view', 'id' => $id_Patient])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipes-index">
    <div class="row">
        <div class="col-sm-11">

        <h2 style="padding-bottom: 10px;"><?= Html::encode($this->title) ?></h2>   
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= \Yii::$app->user->can('manageVisits') ? Html::a(Yii::t('app', 'Create Recipes'), ['create', 'id_Patient' => $id_Patient], ['class' => 'btn btn-success', 'style' => ['margin-bottom' => '10px']]) : "" ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',

                //'create_at',
                [
                    'attribute' => 'create_at',
                    'options' => [
                            'class' => 'col-sm-2',
                        ],
                    //'format' => ['date', 'Y-MM-dd HH:mm'],     
                    'format' => ['date', 'php: Y-m-d H:i']        
                ],
                //'expire',
                [
                    'attribute' => 'expire',
                    'options' => [
                            'class' => 'col-sm-1',
                        ],       
                ],
                'rp',
                'N',
                //'S',
                [
                    'attribute' => 'S',
                    'options' => [
                            'class' => 'col-sm-1',
                        ],       
                ],
                //'fk_patient',
                //'fk_user',
                [
                    'label' => 'Gydytojas',
                    'attribute' => 'user',
                    'value' => 'user.profile.name',
                ],

                ['class' => 'yii\grid\ActionColumn', 'template' => \Yii::$app->user->can('manageVisits') ? '{view} {update} {delete}' : "",
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
                }],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
