<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentPlans */

$this->title = Yii::t('app', 'Update {name} Treatment Plans:', [
    'name' => $model->patientFullName,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '{name}', ['name' => $model->patientFullName]), 'url' => Url::to(['patient/view', 'id' => $id_Patient])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatment Plans'), 'url' => Url::to(['filtered-index', 
    'id_Patient' => $id_Patient])];
$this->params['breadcrumbs'][] = ['label' => $model->patientFullName, 'url' => ['view', 'id' => $model->id, 'id_Patient' => $id_Patient]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), ['treatment-plans/filtered-index', 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary pull-left']) ?>
</div>
<div class="treatment-plans-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'id_Patient' => $id_Patient,
        'patients_list' => $patients_list,
    ]) ?>

</div>
