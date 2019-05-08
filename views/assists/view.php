<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Assists */

$this->title = $model->fkUser->profile->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => Url::to(['visit/timetable'])];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assists-view">
    <div class="row">
        <div class="col-sm-7">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), ['visit/timetable'], ['class' => 'btn btn-primary']) ?>
            </p>

        <h1><?= Html::encode($this->title) ?></h1>

        <!-- <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_assist], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_assist], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p> -->

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'fk_user',
                'start_time',
                'end',
                'info',
            ],
        ]) ?>

        </div>
    </div>

</div>
