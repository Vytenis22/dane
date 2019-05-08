<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = Yii::t('app', 'Update Visit: {name}', [
    'name' => $model->id_visit,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_visit, 'url' => ['view', 'id' => $model->id_visit]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="visit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'hierarchy' => $hierarchy,
        'modelService' => $modelService,
        'visit_status' => $visit_status,
        'patients_list' => $patients_list,
    ]) ?>

</div>
