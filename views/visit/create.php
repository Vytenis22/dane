<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = Yii::t('app', 'Create Visit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'hierarchy' => $hierarchy,
        'modelService' => $modelService,
        'visit_status' => $visit_status,
        'patients_list' => $patients_list,
		'service_category_list' => $service_category_list,
    ]) ?>

</div>
