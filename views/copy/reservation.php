<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\captcha\Captcha;
use app\models\Services;

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
            Informacija su rezervacijos patvirtinimu Jums buvo išsiųsta el. pašto adresu, kurį nurodėte.
        </div>

        <p>
            Rezervacija turite patvirtinti per 1 val., nuo el. laisko gavimo.
        </p>
		
		<?php elseif (Yii::$app->session->hasFlash('reservationError')): ?>
	
			<div class="alert alert-info">
				Registracija nepavyko. Bandykite dar kartą.
			</div>

			<?php elseif (Yii::$app->session->hasFlash('tokenError')): ?>
	
			<div class="alert alert-info">
				Problema su token.
			</div>

    <?php else: ?>

        <p>
            <?= Yii::t('app', 'Fill in reservation form.') ?>
        </p>
        <p>
            <span class="asterix">*</span><?= Yii::t('app', ' fields are required.') ?>
        </p>

        <div class="row">
            <div class="col-sm-3">

            	<?= Html::label(Yii::t('app', 'Category'), 'cat', ['class' => 'label-asterix']); ?>
            	<?= Html::dropDownList('cat', null, $service_category_list, ['prompt' => ['text' => Yii::t('app', 'Select category'),
                             'options'=> ['disabled' => true, 'selected' => true]], 'class'=>'form-control required', 'options' => ['required' => true], 
            			'onchange'=>'
            					$(document.getElementById("services-block").style.display = "block");
            					$.get( "'.Url::toRoute('/copy/clear-doctors', true).'",
														{  } 
												)
													.done(function( data ) {
														console.log("gydytoju listas isvalytas");
														$( "#'.Html::getInputId($model, 'fk_user').'" ).html( data );
														}
													)
													.fail(function() {
												        console.log("error");
												    });
								$.get( "'.Url::toRoute('/copy/clear-times', true).'",
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

        						$.get( "'.Url::toRoute('/copy/services', true).'", { id: $(this).val() } )
									.done(function( data ) {
										console.log("Done pasieke");
										$( "#'.Html::getInputId($modelService, 'fk_id_service').'" ).html( data );
									}
								);								
							']) ?>

				<?php $form = ActiveForm::begin(); ?>

				<div id="services-block" style="display:none;">					
				<?= $form->field($modelService, 'fk_id_service', ['labelOptions' => [ 'class' => 'label-asterix' ]])->dropDownList($services_list, ['prompt' => 'Pasirinkite paslaugą', 'class'=>'form-control required label-asterix', 
							'onchange'=>'
								$(document.getElementById("doctor-block").style.display = "block");
								$.get( "'.Url::toRoute('/copy/doctors', true).'", { id: $(this).val() } )
									.done(function( data ) {
										$( "#'.Html::getInputId($model, 'fk_user').'" ).html( data );
									}
								);
								$.get( "'.Url::toRoute('/copy/clear-times', true).'",
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
							]) ?>
				</div>

				<!-- 'onchange'=>'
							console.log($(this).val());
							$(document.getElementById("doctor-block").style.display = "block");
							$.get( "'.Url::toRoute('/copy/doctors', true).'", { id: $(this).val() } )
								.done(function( data ) {
									$( "#'.Html::getInputId($model, 'fk_user').'" ).html( data );
								}
							);
							$.get( "'.Url::toRoute('/copy/clear-times', true).'",
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
						' -->
				

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
						<?= $form->field($model, 'fk_user', ['labelOptions' => [ 'class' => 'label-asterix' ]])->dropDownList( ['prompt' => 'Pasirinkite gydytoja', 'class'=>'form-control required label-asterix'])->label("Gydytojas") ?>
					</div>
					
					<div id="start-date-block" style="display:none;">
						<?= $form->field($model, 'tmpdate', 
										[ 'labelOptions' => [ 'class' => 'label-asterix' ],
										'options' => [
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
							$form->field($model, 'time', ['labelOptions' => [ 'class' => 'label-asterix' ]])->dropDownList( ['prompt' => 'Pasirinkite laiką'])->label("Laikas")
						?>
					</div>
					<div id="patient-info-block" style="display:none;">
						<?= $form->field($modelPatient, 'name', ['labelOptions' => [ 'class' => 'label-asterix' ]])->textInput(['maxlength'=> 35], ['prompt' => 'Įveskite savo vardą'])->input('name', ['placeholder' => 'Įveskite savo vardą']); ?>
					
						<?= $form->field($modelPatient, 'surname', ['labelOptions' => [ 'class' => 'label-asterix' ]])->textInput(['maxlength'=> 35], ['prompt' => 'Įveskite savo pavarde'])->input('surname', ['placeholder' => 'Įveskite savo pavardę']); ?>

						<?= $form->field($modelPatient, 'code', ['labelOptions' => [ 'class' => 'label-asterix' ]])->textInput(['maxlength'=> 11], ['prompt' => 'Įveskite asmens kodą'])->input('code', ['placeholder' => 'Įveskite asmens kodą']); ?>
					
						<?= $form->field($modelPatient, 'email', ['labelOptions' => [ 'class' => 'label-asterix' ]])->textInput(['maxlength'=> 35])->input('email', ['placeholder' => 'Įveskite savo el. paštą']); ?>
					
						<?= $form->field($modelPatient, 'phone', ['labelOptions' => [ 'class' => 'label-asterix' ]])->textInput(['maxlength'=> 15], ['prompt' => 'Įveskite savo vardą'])->input('phone', ['placeholder' => 'Įveskite savo telefoną (86...)']); ?>

						<?= $form->field($modelPatient, 'sex', ['labelOptions' => [ 'class' => 'label-asterix' ]])->textInput(['maxlength'=> 7])->dropDownList(['moteris' => 'moteris', 'vyras' => 'vyras'], ['prompt'=>'Pasirinkite lytį']); ?>
						
						<?= $form->field($modelPatient, 'verifyCode', ['labelOptions' => [ 'class' => 'label-asterix' ]])->widget(Captcha::className(), [
							'template' => '<div class="row"><div class="col-sm-10">{image}</div><div class="col-sm-9">{input}</div></div>',
								'options' => ['placeholder' => 'Įveskite patvirtinimo kodą'],
						]) ?>
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
