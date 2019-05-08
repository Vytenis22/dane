<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentTime */

$this->title = Yii::t('app', 'Update Treatment Time: {name}', [
    'name' => $model->id_treatment_time,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatment Times'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_treatment_time, 'url' => ['view', 'id_treatment_time' => $model->id_treatment_time, 'fk_id_service' => $model->fk_id_service]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="treatment-time-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
