<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Treatment */

$this->title = $model->id_treatment;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="treatment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id_treatment' => $model->id_treatment, 'fk_id_service' => $model->fk_id_service], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id_treatment' => $model->id_treatment, 'fk_id_service' => $model->fk_id_service], [
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
            'price',
            'id_treatment',
            'fk_id_treatment_type',
            'fk_id_service',
        ],
    ]) ?>

</div>
