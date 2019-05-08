<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Services */
?>

<?= Html::a(Yii::t('app', 'Return'), ['services/index'], ['class' => 'btn btn-primary']) ?>

<?php

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="services-view">
    <div class="row">
        <div class="col-sm-5">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'name',
                //'parent_id',
                [
                    'label' => 'Kategorija',
                    'attribute' => 'category.parent_name',
                    //'value' => 'category.parent_name',
                    'options' => [
                        'class' => 'col-sm-2',
                    ]
                ],
                [
                    'attribute' => 'price',
                    'label' => Yii::t('app', 'Price'),
                    'options' => [
                            'class' => 'col-sm-1',
                        ],       
                ],
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
