<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentPlans */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), ['filtered-index', 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = $model->patientFullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '{name}', ['name' => $model->patientFullName]), 'url' => Url::to(['patient/view', 'id' => $id_Patient])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatment Plans'), 'url' => Url::to(['filtered-index', 
    'id_Patient' => $id_Patient])];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="treatment-plans-view">

    <h2><?= Html::encode($this->title) . " " . Yii::t('app', 'treatment plan') ?></h2>

    <div class="row">
        <div class="col-lg-8">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'begin',
                    'end',
                    'info:ntext',
                    [
                        'label' => 'Pacientas',
                        'attribute' => 'patientFullName',               
                    ],
                    [
                        'label' => 'Gydytojas',
                        'attribute' => 'user.profile.name',               
                    ],
                    //'fk_patient',
                ],
            ]) ?>

        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'id_Patient' => $id_Patient], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
