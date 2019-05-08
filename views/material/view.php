<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Material */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="material-view">
    <div class="row">
        <div class="col-sm-8">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), ['material/index'], ['class' => 'btn btn-primary']) ?>
            </p>

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id_material',
                'name',
                'price',
                'info',
    			[
    				'label' => 'Tipas',
    				'attribute' => 'matName',				
    			],
    			
                //'fk_id_material_type',
            ],
        ]) ?>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_material], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_material], [
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
