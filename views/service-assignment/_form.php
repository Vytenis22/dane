<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-assignment-form">
    <div class="row">
        <div class="col-sm-4">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'user_id')->textInput()->dropDownList($users_profiles_list, 
	            ['prompt' => Yii::t('app', 'Select doctor'), 
							'onchange'=>'
								$.get( "'.Url::toRoute('/service-assignment/services', true).'", { id: $(this).val() } )
									.done(function( data ) {
										$( "#'.Html::getInputId($model, 'category_id').'" ).html( data );
									}
								)
													.fail(function() {
												        console.log("error");
												    });
							' ]) ?>

	    <?= $form->field($model, 'category_id')->textInput()->dropDownList([],/*$categories_list,*/ 
	            ['prompt' => Yii::t('app', 'Select category')]) ?>

	    <div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
