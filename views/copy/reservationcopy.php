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
<script type='text/javascript'>
	var dates;

	var c_date = new Date();
	var date_f = c_date.getFullYear();
	date_f+= "-";
	var month = c_date.getMonth() +1;
	if(month < 10) {
        date_f+= "0" + month; 
	} else {
		date_f+= month;
	}
	date_f+= "-";
	var day = c_date.getDate();
	if(day < 10) {
        date_f+= "0" + day; 
	} else {
		date_f+= day;
	}
	//var js_array = Object.entries(js_obj);
	//die();
</script>

<!-- <script>
	function checkedRed() {
	  alert("red");
	}
	function checkedBlue() {
	  alert("blue");
	}
</script> -->

<div class="visit-reservation">
	<h1><?= Html::encode($this->title) ?></h1>
	
	<?php if (Yii::$app->session->hasFlash('confirmationSent')): ?>

        <div class="alert alert-success">
            Informacija su rezervacijos patvirtinimu Jums buvo išsiųsta el. pašto adresu, kurį nurodėte.
        </div>

        <p>
            Rezervaciją turite patvirtinti per 1 val., nuo el. laiško gavimo.
        </p>
		
		<?php elseif (Yii::$app->session->hasFlash('reservationError')): ?>
	
			<div class="alert alert-info">
				Registracija nepavyko. Bandykite dar kartą.
			</div>

			<?php elseif (Yii::$app->session->hasFlash('tokenError')): ?>
	
			<div class="alert alert-info">
				Problema su rezervacija.
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
            					$.get( "'.Url::toRoute('/copy/clear-doctors', true).'",
														{  } 
												)
													.done(function( data ) {
														var variable = $(document.getElementById("visit-fk_user")).val();
														console.log("sitas", variable);
														if (typeof variable != "undefined") {
															console.log("gydytoju listas isvalytas");
															$( "#'.Html::getInputId($model, 'fk_user').'" ).html( data );
														}														
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
            					$(document.getElementById("services-block").style.display = "block");		
            					if (typeof (document.getElementById("visit-tmpdate").value) != "undefined") {
									document.getElementById("visit-tmpdate").value = "";
								}					
							']) ?>

				<?php $form = ActiveForm::begin(); ?>

				<div id="services-block" style="display:none;">					
				<?= $form->field($modelService, 'fk_id_service', ['labelOptions' => [ 'class' => 'label-asterix' ]])->dropDownList($services_list, ['prompt' => 'Pasirinkite paslaugą', 'class'=>'form-control required label-asterix', 
							'onchange'=>'
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
								//$(document.getElementById("radio-buttons").style.display = "block");
								$(document.getElementById("doctor-block").style.display = "block");				
							' 
							]) ?>
				</div>				

				<!-- Radio buttons, pasirinkti arba ne konkretu gydytoja -->
				<!-- <div id="radio-buttons" style="display:none;">
					<form>
						Pasirinkite vieną<br>
						<input type="radio" name="buttons" id="doc">Pasirinkti gydytoją<br>
						<input type="radio" name="buttons" id="no-doc">Gydytojas neaktualu
					</form>
				</div>   -->          	

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
						<?= $form->field($model, 'fk_user', ['labelOptions' => [ 'class' => 'label-asterix' ], 
						'options' => ['onchange' => ' 
								var doc_id = $(document.getElementById("visit-fk_user")).val();
								var service_id = $(document.getElementById("orderedservice-fk_id_service")).val();

								$.get( "'.Url::toRoute('/visit/unavailable', true).'",
										{ doc_id : $(document.getElementById("visit-fk_user")).val(),
											service_id : $(document.getElementById("orderedservice-fk_id_service")).val()
										 } 
								)
								.done(function( data ) {
									var myobj = JSON.parse(data);					
									dates = Object.values(myobj);
									console.log(dates);
									/*localStorage.setItem("unv_dates", dates);*/
								}
								)
								.fail(function( jqXHR, textStatus, errorThrown ) {
							        console.log(jqXHR);
							        console.log(textStatus);
							        console.log(errorThrown );
							    });


							    /*$("#visit-tmpdate").kvDatepicker("disabled: true");*/


								']])
						->dropDownList( [])->label("Gydytojas") ?>
					</div>
					
					<div id="start-date-block" style="display:none;">
						<?= $form->field($model, 'tmpdate', 
										[ 'labelOptions' => [ 'class' => 'label-asterix' ],
										'options' => [
											'onchange'=>'
												$.get( "'.Url::toRoute('/copy/times', true).'",
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
							)->widget(\yii\jui\DatePicker::class, [
							    'language' => 'lt',
							    'options' => ['placeholder' => 'Pasirinkite datą ...', ],
							    'clientOptions' => [
							    	'minDate' => '1',
							    	'beforeShowDay' => new \yii\web\JsExpression('function(date) { 
				                        var year = date.getFullYear();
				                        holidays = [year + "-01-01", year + "-02-16", year + "-03-11", year + "-05-01", year + "-06-24", year + "-07-06", year + "-08-15", year + "-11-01", year + "-12-25", year + "-12-26", "2020-04-13", "2021-04-05", "2022-04-18"];

				                        var dmy = date.getFullYear();
				                        dmy+= "-";
				                        var month = date.getMonth() +1;
				                        if(month < 10) {
				                            dmy+= "0" + month; 
				                        } else {
				                            dmy+= month;
				                        }
				                        dmy+= "-";
				                        var day = date.getDate();
				                        if(day < 10) {
				                            dmy+= "0" + day; 
				                        } else {
				                            dmy+= day;
				                        }

				                        if ($.inArray(dmy, holidays) > -1 && date.getUTCDay() < 5 && dmy > date_f  ||
										 $.inArray(dmy, dates) > -1) {
				                            return [false, "highlight-day", ""]
				                        } else if (date.getUTCDay() > 4) {
				                            return [false, "", ""]
				                        } else {
				                            return [true, "", ""]
				                        }                

				                     }'),
							    ],
							    
							    //'dateFormat' => 'yyyy-MM-dd',
							])->label("Data"); ?>
					</div>
					
					<div id="start-time-block" style="display:none;">
						<?= //$form->field($model, 'end')->dropDownList(range(0, 59, 15), ['prompt' => 'Pasirinkite laiką'])
							//$form->field($model, 'time')->dropDownList(['12:00' => '12:00', '13:00' => '13:00'], ['prompt' => 'Pasirinkite laiką']) 
							$form->field($model, 'time', ['labelOptions' => [ 'class' => 'label-asterix' ]])->dropDownList( ['prompt' => 'Pasirinkite laiką'])->label("Laikas")
						?>
					</div>

					<!-- Radio buttons - esamas ar naujas klientas -->
					<div id="radio-buttons" style="display:none;">
						Pasirinkite vieną<br>
						<input type="radio" name="buttons" id="client">Esamas klientas<br>
						<input type="radio" name="buttons" id="new-client">Naujas klientas
					</div>

					<div id="patient-block" style="display:none;">
						<?= $form->field($modelPatient, 'name', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->textInput(['maxlength'=> 35], ['prompt' => 'Įveskite savo vardą'])
						->input('name', ['placeholder' => 'Įveskite savo vardą']); ?>
					
						<?= $form->field($modelPatient, 'surname', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->textInput(['maxlength'=> 35], ['prompt' => 'Įveskite savo pavarde'])
						->input('surname', ['placeholder' => 'Įveskite savo pavardę']); ?>

						<?= $form->field($modelPatient, 'code', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->textInput(['maxlength'=> true, 'placeholder' => 'Įveskite asmens kodą']); ?>
					
						<?= $form->field($modelPatient, 'email', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->textInput(['maxlength'=> true, 'placeholder' => 'Įveskite savo el. paštą']); ?>
					</div>

					<div id="new-patient-block" style="display:none;">

						<?php $modelPatient->birth_date = "2000-01-01"; ?>

						<?= $form->field($modelPatient, 'birth_date')->textInput(['maxlength' => true, 'placeholder' => 
							'Pasirinkite datą ...'])
			                ->widget(DatePicker::classname(), [
	                            'options' => ['placeholder' => 'Pasirinkite datą ...'],                            
	                            'removeButton' => false,
                            	'value' => "1999-01-01", 
	                            'language' => 'lt', 	                                                   
	                            'pluginOptions' => [
	                                'autoclose' => true,
	                                'format' => 'yyyy-mm-dd',
	                                'todayHighlight' => true,
	                                'todayBtn' => true,
	                            ],
	                             
	                        ]) ?>
					
						<?= $form->field($modelPatient, 'phone', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->textInput(['maxlength' => true, 'minlength' => true, 
						'placeholder' => 'Įveskite telefono numerį (86...)']); ?>

						<?php $modelPatient->city = 1; ?>

						<?= $form->field($modelPatient, 'city', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->dropDownList($cities_list, ['prompt' => ['text' => Yii::t('app', 'Select city'), 'options'=> 
						['disabled' => true, 'selected' => true]]]); ?>

						<?= $form->field($modelPatient, 'address', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->textInput(['maxlength'=> 100], ['prompt' => 'Įveskite adresą'])
						->input('address', ['placeholder' => 'Įveskite adresą']); ?>

						<?= $form->field($modelPatient, 'sex', ['labelOptions' => [ 'class' => 'label-asterix' ]])
						->textInput(['maxlength'=> 7])
						->dropDownList(['moteris' => 'moteris', 'vyras' => 'vyras'], ['prompt'=> ['text' => 
						Yii::t('app', 'Select sex'), 'options'=> ['disabled' => true, 'selected' => true]]]); ?>
					</div>

					<div id="res-button" class="form-group" style="display:none;">
						
						<?= $form->field($modelPatient, 'verifyCode', ['labelOptions' => [ 'class' => 'label-asterix' ]])->widget(Captcha::className(), [
							'template' => '<div class="row"><div class="col-sm-10">{image}</div><div class="col-sm-9">{input}</div></div>',
								'options' => ['placeholder' => 'Įveskite patvirtinimo kodą'],
						]) ?>

						<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
					</div>
				<?php ActiveForm::end();

				//, ['options' => ['class' => 'time-label', 'style' => 'display: none']]              , 'style' => 'display:none']
				?>				

            </div>
        </div>

    <?php endif; ?>

</div><!-- visit-reservation -->
