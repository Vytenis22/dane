<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentTime */

$this->title = $model->id_treatment_time;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatment Times'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="treatment-time-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id_treatment_time' => $model->id_treatment_time, 'fk_id_service' => $model->fk_id_service], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id_treatment_time' => $model->id_treatment_time, 'fk_id_service' => $model->fk_id_service], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'duration',
            'id_treatment_time:datetime',
            'fk_id_service',
        ],
    ]) ?>

</div>
