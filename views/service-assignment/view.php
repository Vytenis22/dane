<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceAssignment */
?>

<?= Html::a(Yii::t('app', 'Return'), ['service-assignment/index'], ['class' => 'btn btn-primary']) ?>

<?php

$this->title = $model->profile->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="service-assignment-view">
    <div class="row">
        <div class="col-sm-5">

        <h2><?= Html::encode($this->title) ?></h2>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'user_id',
                [
                    'label' => 'Gydytojas',
                    'attribute' => 'user.profile.name',
                ],
                //'category_id',
                [
                    'label' => 'Kategorija',
                    'attribute' => 'category.parent_name',
                ],
                'created_at',
            ],
        ]) ?>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'user_id' => $model->user_id, 'category_id' => $model->category_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'user_id' => $model->user_id, 'category_id' => $model->category_id], [
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
