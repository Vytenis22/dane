<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Treatment */

$this->title = Yii::t('app', 'Update Treatment: {name}', [
    'name' => $model->id_treatment,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_treatment, 'url' => ['view', 'id_treatment' => $model->id_treatment, 'fk_id_service' => $model->fk_id_service]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="treatment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
