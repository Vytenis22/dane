<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Assists */

$this->title = Yii::t('app', 'Update Assists: {name}', [
    'name' => $model->fkUser->profile->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => Url::to(['visit/timetable'])];
//$this->params['breadcrumbs'][] = ['label' => $model->fkUser->profile->name, 'url' => ['view', 'id' => $model->id_assist]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="assists-update">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), ['visit/timetable'], ['class' => 'btn btn-primary']) ?>
            </p>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formassist', [
        'model' => $model,
    ]) ?>

</div>
