<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = Yii::t('app', 'Update Visit: {name}', [
    'name' => $model->patient->fullName,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => ['timetable']];
//$this->params['breadcrumbs'][] = ['label' => $model->patient->fullName, 'url' => ['view', 'id' => $model->id_visit]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="visit-update">
	<div class="row">
		<div class="col-sm-6">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), ['timetable'], ['class' => 'btn btn-primary']) ?>
            </p>

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_formupdate', [
	        'model' => $model,
	        'hierarchy' => $hierarchy,
	        'modelService' => $modelService,
	        'visit_status' => $visit_status,
	        'patients_list' => $patients_list,
            'service_category_list' => $service_category_list,
            'services_list' => $services_list,
	    ]) ?>
		</div>
	</div>

</div>
