<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MaterialType */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['/material-type/index']), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Materials'), 'url' => Url::to(['/material/index'])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Material Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="material-type-view">
    <div class="row">
        <div class="col-sm-5">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'id_material_type',
            ],
        ]) ?>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_material_type], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_material_type], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
            </div>
    </div>

</div>
