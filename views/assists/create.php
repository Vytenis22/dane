<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Assists */

$this->title = Yii::t('app', 'Create Assists');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assists-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
