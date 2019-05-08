<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Recipes */

$this->title = Yii::t('app', 'Update {name} Recipes:', [
    'name' => $model->patientFullName,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '{name}', ['name' => $model->patientFullName]), 'url' => Url::to(['patient/view', 'id' => $id_Patient])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->patientFullName, 'url' => ['view', 'id' => $model->id, 'id_Patient' => $id_Patient]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), ['recipes/filtered-index', 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary pull-left']) ?>
</div>
<div class="recipes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id_Patient' => $id_Patient,
        'patients_list' => $patients_list,
    ]) ?>

</div>
