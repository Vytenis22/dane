<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'create_at') ?>

    <?= $form->field($model, 'expire') ?>

    <?= $form->field($model, 'rp') ?>

    <?= $form->field($model, 'N') ?>

    <?php // echo $form->field($model, 'S') ?>

    <?php // echo $form->field($model, 'fk_patient') ?>

    <?php // echo $form->field($model, 'fk_user') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
