<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AssistsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assists-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_assist') ?>

    <?= $form->field($model, 'fk_user') ?>

    <?= $form->field($model, 'reg_nr') ?>

    <?= $form->field($model, 'start_time') ?>

    <?= $form->field($model, 'end') ?>

    <?php // echo $form->field($model, 'info') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
