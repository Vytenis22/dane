<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceCategory */
?>

<?= Html::a(Yii::t('app', 'Return'), ['service-category/index'], ['class' => 'btn btn-primary']) ?>

<?php

$this->title = $model->parent_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => Url::to(['/services/index'])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="service-category-view">
    <div class="row">
        <div class="col-sm-4">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'parent_name',
            ],
        ]) ?>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
