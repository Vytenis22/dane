<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\MaterialType;

/* @var $this yii\web\View */
/* @var $model app\models\Material */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-form">
    <div class="row">
        <div class="col-sm-5">
            <!-- <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), ['material/index'], ['class' => 'btn btn-primary']) ?>
            </p> -->

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'price')->textInput() ?>

        <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>
    	
    	<?= $form->field($model, 'fk_id_material_type')->dropDownList(
    		ArrayHelper::map(MaterialType::find()->all(), 'id_material_type', 'name'),
    		['prompt' => 'Pasirinkite medžiagų tipą']
    	)->label('Tipas') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
