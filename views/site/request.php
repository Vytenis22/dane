<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Atšaukti registraciją';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request col-lg-6">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php if (Yii::$app->session->hasFlash('requestFormError')): ?>

        <div class="alert alert-danger col-lg-11" style="display: inline-block;">
            Klaidingas registracijos numeris.
        </div>
		
		<?= Html::button('Grįžti atgal', ['class' => 'btn btn-primary', 'id' => 'button-reload']) ?>

    <?php elseif (Yii::$app->session->hasFlash('requestSent')): ?>
	
			<div class="alert alert-success col-lg-6">
				Laiškas su vizito atšaukimo nuoroda išsiųstas nurodytu el. paštu.
			</div>
			
			<?php else:?>
		
		<div class="row">
				<div class="col-lg-4"> 
		
		<?php
		
		$form = ActiveForm::begin([
			'id' => 'request-form',
			//'options' => ['class' => 'form-horizontal'],
		]) ?>
			<?= $form->field($model, 'reg_nr')->textInput(['maxlength'=>8, 'minlength'=>8]); ?>

			<div class="form-group">
				<!--<div class="col-lg-offset-1 col-lg-11"> -->
					<?= Html::submitButton(yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'request-button']) ?>
				<!--</div> -->
			</div>
		<?php ActiveForm::end() 

		?>
			</div>
		</div>
		
	<?php endif; ?>	
	
	<?php	
	
	/**
	Modal::begin([
            'header'=>'<h4>Atšaukti</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
			'toggleButton' => ['label' => 'click me'],
        ]);
        
        echo "<div id='modalContent'></div>";
        Modal::end();
		*/
	
	?>
</div>
