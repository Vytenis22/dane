<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $form ActiveForm */

$this->title = Yii::t('app', 'Reservation');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-reservation">
	<h1><?= Html::encode($this->title) ?></h1>
	
	<?php if (Yii::$app->session->hasFlash('confirmationSent')): ?>

        <div class="alert alert-success">
            Informacija su rezervacijos patvirtinimu Jums buvo issiusta el. pasto adresu, kuri nurodete.
        </div>

        <p>
            Rezervacija turite patvirtinti per 1 val., nuo el. laisko gavimo.
        </p>
		
		<?php elseif (Yii::$app->session->hasFlash('reservationError')): ?>
	
			<div class="alert alert-info">
				Registracija nepacyko. Bandykite dar kartą.
			</div>

			<?php elseif (Yii::$app->session->hasFlash('tokenError')): ?>
	
			<div class="alert alert-info">
				Problema su token.
			</div>

    <?php else: ?>

        <p>
            <?= Yii::t('app', 'Fill in reservation form.') ?>
        </p>

        <div class="row">
            <div class="col-lg-5">

				<?php $form = ActiveForm::begin(); ?>
				
					<?=
						$form->field($modelService, 'fk_id_service', [
							'inputOptions' => [
								'class' => 'selectpicker '
							]
						]
						)->dropDownList($hierarchy_list, ['prompt' => 'Pasirinkite paslaugą', 'class'=>'form-control required', 
							'onchange'=>'
								$.get( "'.Url::toRoute('/site/doctors', true).'", { id: $(this).val() } )
									.done(function( data ) {
										$( "#'.Html::getInputId($model, 'fk_user').'" ).html( data );
									}
								);
								$.get( "'.Url::toRoute('/site/clear-times', true).'",
														{  } 
												)
													.done(function( data ) {
														console.log($(document.getElementById("visit-tmpdate")).val());
														$( "#'.Html::getInputId($model, 'time').'" ).html( data );
														}
													)
													.fail(function() {
												        console.log("error");
												    });
							' 
							]);
					?>
				
				<!--
						$form->field($modelService, 'fk_id_service', [
							'inputOptions' => [
								'class' => 'selectpicker '
							]
						]
						)->dropDownList($hierarchy, ['prompt' => 'Pasirinkite antra paslaugą', 'class'=>'form-control required']);
				-->
					
					<!-- Html::activeDropDownList($model, 'fk_user', $items) -->
					<div id="doctor-block" style="display:none;">
						<?= $form->field($model, 'fk_user')->dropDownList( ['prompt' => 'Pasirinkite gydytoja'])->label("Gydytojas") ?>
					</div>
					
					<div id="start-date-block" style="display:none;">
						<?= $form->field($model, 'tmpdate', 
										['options' => [
											'onchange'=>'
												$.get( "'.Url::toRoute('/site/times', true).'",
														{ dates: $(document.getElementById("visit-tmpdate")).val(), 
															id : $(document.getElementById("visit-fk_user")).val(),
															service : $(document.getElementById("orderedservice-fk_id_service")).val()
														 } 
												)
													.done(function( data ) {
														console.log($(document.getElementById("visit-tmpdate")).val());
														$( "#'.Html::getInputId($model, 'time').'" ).html( data );
														}
													)
													.fail(function( jqXHR, textStatus, errorThrown ) {
												        console.log(jqXHR);
												        console.log(textStatus);
												        console.log(errorThrown );
												    });
											'
											],
										]
							)->widget(DatePicker::classname(), [
							'options' => ['placeholder' => 'Pasirinkite data ...'],							
							'removeButton' => false,
							'language' => 'lt',							
							'pluginOptions' => [
								'autoclose' => true,
								'daysOfWeekDisabled' => [0, 6],
								//'format' => 'yyyy-MM-dd',
								'todayHighlight' => true,
								'todayBtn' => true,
								//'startDate' => "0d",
								'startDate' => date('Y-m-d', strtotime('+1 day')),
							],
							 
							])->label("Data"); ?>
					</div>
					
					<div id="start-time-block" style="display:none;">
						<?= //$form->field($model, 'end')->dropDownList(range(0, 59, 15), ['prompt' => 'Pasirinkite laiką'])
							//$form->field($model, 'time')->dropDownList(['12:00' => '12:00', '13:00' => '13:00'], ['prompt' => 'Pasirinkite laiką']) 
							$form->field($model, 'time')->dropDownList( ['prompt' => 'Pasirinkite laiką'])->label("Laikas")
						?>
					</div>
					<div id="patient-info-block" style="display:none;">
						<?= $form->field($modelPatient, 'name')->textInput(['maxlength'=> 35], ['prompt' => 'Iveskite savo vardą'])->input('name', ['placeholder' => 'Įveskite savo vardą']); ?>
					
						<?= $form->field($modelPatient, 'surname')->textInput(['maxlength'=> 35], ['prompt' => 'Iveskite savo pavarde'])->input('surname', ['placeholder' => 'Įveskite savo pavardę']); ?>
					
						<?= $form->field($modelPatient, 'email')->textInput(['maxlength'=> 35])->input('email', ['placeholder' => 'Įveskite savo el. paštą']); ?>
					
						<?= $form->field($modelPatient, 'phone')->textInput(['maxlength'=> 15], ['prompt' => 'Iveskite savo vardą'])->input('phone', ['placeholder' => 'Įveskite savo telefoną (86...)']); ?>

						<?= $form->field($modelPatient, 'sex')->textInput(['maxlength'=> 7])->dropDownList(['moteris' => 'moteris', 'vyras' => 'vyras'], ['prompt'=>'Pasirinkite lytį']); ?>
						
						<?= $form->field($modelPatient, 'verifyCode')->widget(Captcha::className(), [
							'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
						])->input('verifyCode', ['placeholder' => 'Įveskite patvirtinimo kodą']) ?>
					</div>				
					<div id="res-button" class="form-group" style="display:none;">
						<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
					</div>
				<?php ActiveForm::end();

				//, ['options' => ['class' => 'time-label', 'style' => 'display: none']]              , 'style' => 'display:none']
				?>
				

            </div>
        </div>

    <?php endif; ?>

</div><!-- visit-reservation -->
