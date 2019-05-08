<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = $model->patient->name . " " . $model->patient->surname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => Url::to(['visit/timetable'])];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="visit-view">
    <div class="row">
        <div class="col-sm-7">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), ['timetable'], ['class' => 'btn btn-primary']) ?>
            </p>

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'start_time',
                'room',
                'info',
                'total_price',
                'payment',
                'id_visit',
                'fk_user',
                'fk_patient',
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
