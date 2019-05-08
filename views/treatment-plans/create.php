<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentPlans */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), ['filtered-index', 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Create Treatment Plans');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '{name}', ['name' => $model->patientFullName]), 'url' => Url::to(['patient/view', 'id' => $id_Patient])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatment Plans'), 'url' => Url::to(['filtered-index', 
	'id_Patient' => $id_Patient])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treatment-plans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id_Patient' => $id_Patient,
    ]) ?>

</div>
