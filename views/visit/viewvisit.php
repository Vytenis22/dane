<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = $model->patient->name . " " . $model->patient->surname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => Url::to(['patient/visits', 'id' => \Yii::$app->user->id])];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="visit-view">
    <div class="row">
        <div class="col-sm-7">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), Url::to(['patient/visits', 'id' => \Yii::$app->user->id]), ['class' => 'btn btn-primary']) ?>
            </p>

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'reg_nr',
                'start_time',
                'end',
                'room',
                'info',
                [
                    'attribute' => 'services',
                    'value' => function($model) {
                        return implode(\yii\helpers\ArrayHelper::map($model->services, 'id', 'name'));
                    },
                    //'label' => Yii::t('app', 'Price'),      
                ],
                //'total_price',
                [
                    'attribute' => 'total_price',
                    'label' => Yii::t('app', 'Price'),      
                ],
                //'payment',
                [
                    'label' => 'Būsena',
                    'attribute' => 'paymentName.name',               
                ],
                //'fk_user',
                [
                    'label' => 'Gydytojas',
                    'attribute' => 'user.profile.name',               
                ],
                //'fk_patient',
            ],
        ]) ?>

        <!-- <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_visit], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update-tmp', 'id' => $model->id_visit], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_visit], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p> -->
        </div>
    </div>
    

</div>
