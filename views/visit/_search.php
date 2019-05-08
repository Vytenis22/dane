<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VisitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'start_time') ?>

    <?= $form->field($model, 'room') ?>

    <?= $form->field($model, 'info') ?>

    <?= $form->field($model, 'total_price') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'id_visit') ?>

    <?php // echo $form->field($model, 'fk_user') ?>

    <?php // echo $form->field($model, 'fk_patient') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
