<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */

$this->title = Yii::t('app', 'Update Patient: {name}', [
    'name' => $model->name,
]);
\Yii::$app->user->can('viewVisit') ? $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']] : "";
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_Patient]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="return-button">
<?= \Yii::$app->user->can('viewVisit') ? Html::a(Yii::t('app', 'Return'), ['patient/view', 'id' => $model->id_Patient], ['class' => 'btn btn-primary pull-left']) : Html::a(Yii::t('app', 'Return'), ['patient/view-patient', 'id' => \Yii::$app->user->id], ['class' => 'btn btn-primary pull-left']) ?>
</div>
<div class="patient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cities_list' => $cities_list,
    ]) ?>

</div>
