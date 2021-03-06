<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use dektrium\user\models\User;
use app\models\Cities;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CancelForm;
use app\models\RequestForm;
use app\models\Profile;
use app\models\TokenPatient;
use app\models\Patient;
use app\models\Service;
use app\models\OrderedService;
use app\models\AuthAssignment;
use app\models\Visit;
use app\models\Assists;
use app\models\Services;
use app\models\ServiceCategory;
use app\models\ServiceDuration;
use app\models\ServiceAssignment;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use DateTime;
use DatePeriod;
use DateInterval;

class CopyController extends Controller
{	
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
					[
                        'actions' => ['language'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionCancel($patient_id, $code, $visit_id)
	{
		$token = TokenPatient::find()->where(['patient_id' => $patient_id, 'code' => $code, 'type' => TokenPatient::TYPE_CANCEL])->one();
        if (empty($token) || ! $token instanceof TokenPatient) {
            throw new NotFoundHttpException();
        }
		if ($token === null || $token->isExpired) {			
            //$this->trigger(self::EVENT_AFTER_TOKEN_VALIDATE, $event);
            //\Yii::$app->session->setFlash('cancelTokenExpired');
            //throw new NotFoundHttpException();
			return $this->render('cancel');
            //return $this->refresh();
        }
		
		$visit = Visit::find()->where(['id_visit' => $visit_id])->one();
		if (!($visit)) {
				Yii::$app->session->setFlash('cancelTokenExpired');
				return $this->refresh();
		}
		if (!$token->delete()){
            return false;
		}
		if (!$visit->delete()){
			\Yii::$app->session->setFlash('cancelTokenExpired');

            return $this->refresh();
		}
		Yii::$app->session->setFlash('visitCanceled');
		
        /* $model = new CancelForm();
		if ($model->load(Yii::$app->request->post())) {
            //Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } */
		
		return $this->render('cancel');
	}
	
	/**
     * Request cancel action.
     *
     * @return Response
     */
	public function actionRequest()
    {				
		$model = new RequestForm();
		
		if ($model->load(Yii::$app->request->post())) {
			$visit = Visit::find()->where(['reg_nr' => $model->reg_nr])->one();
			if (!($visit)) {
				Yii::$app->session->setFlash('requestFormError');
				return $this->refresh();
			}
			
			date_default_timezone_set('Europe/Vilnius');
			//$timeSet = date('2019-03-15 23:55:00');
			$timeSet = $visit->start_time;
			$timeNow = date('Y-m-d H:i:s');
			$timeSetFormat = date("Y-m-d", strtotime($timeSet));
			
			if ($timeNow >= $timeSetFormat) {
				Yii::$app->session->setFlash('requestFormError');
				return $this->refresh();
			}	
			$token = \Yii::createObject([
					'class' => TokenPatient::className(),
					'visit_id' => $visit->id_visit,
					'patient_id' => $visit->fk_patient,
					'type' => TokenPatient::TYPE_CANCEL,					
				]);
			if (!$token->save(false)) {
				return false;
			}
			Yii::$app->mailer->compose('request', ['patient' => $patient = $visit->patient, 'visit' => $visit, 'token' => $token])
				 ->setFrom([Yii::$app->params['adminEmail']])
				 ->setTo($patient->email)
				 ->setSubject("Request")
				 ->send();
				
			Yii::$app->session->setFlash('requestSent');

			return $this->refresh();
        }
        return $this->render('request', ['model' => $model,]);
    }
		
	public function actionStatus()
    {
        return $this->render('status');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
	
	/**
     * Creates a new Visit model for guest reservation.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionReservation()
    {		
    	$cities = Cities::find()->all();
    	$cities_list = ArrayHelper::map($cities, 'id', 'name');
    	//$service_category = Services::find()->where(['parent_id' => 0])->all();
    	$service_category = ServiceCategory::find()->all();
    	$service_category_list = ArrayHelper::map($service_category, 'id', 'parent_name');
    	$services = Services::find()->all();
    	$services_list = ArrayHelper::map($services, 'id', 'name');
		
		$model = new Visit();
		$model->scenario = Visit::SCENARIO_AUTO;

		$modelService = new OrderedService();
		$modelPatient = \Yii::createObject([
            'class'    => Patient::className(),
            'scenario' => Patient::SCENARIO_AUTO,
        ]);	
		// loading models from reservation page form. Converting selected date to minutes and then add time
        if ($model->load(Yii::$app->request->post()) && $modelService->load(Yii::$app->request->post())) {
			$duration = ServiceDuration::find()
			->where(['service_id' => $modelService->fk_id_service])
			->one();
				
			$model->tmptime = $model->time;
			$minutes = 0; 
			if (strpos($model->tmptime, ':') !== false) 
			{ 
				// Split hours and minutes. 
				list($model->tmptime, $minutes) = explode(':', $model->tmptime); 
			} 
			$start_time_minutes =  $model->tmptime * 60 + $minutes;			
			
			$model->start_time = date('Y-m-d H:i:s',strtotime($model->tmpdate . '+ '. $start_time_minutes .' minutes'));	

			$minutes = 0; 
			$duration_m = $duration->duration;
			if (strpos($duration_m, ':') !== false) 
			{ 
				// Split hours and minutes. 
				list($duration_m, $minutes) = explode(':', $duration_m); 
			} 
			$duration_minutes =  $duration_m * 60 + $minutes;
			
			$model->end = date('Y-m-d H:i:s',strtotime($model->start_time . '+ '. $duration_minutes .' minutes'));	
			
			if ($modelPatient->load(Yii::$app->request->post())) 
			{
				$if_exists = Patient::findOne([
					'name' => $modelPatient->name,
					'surname' => $modelPatient->surname,
					//'code' => $modelPatient->code,
				]);
				$patient_contacts;
				if (is_null($if_exists)) 
				{
					if ($modelPatient->save())
					{
						$model->fk_patient = $modelPatient->id_Patient;
						$patient_contacts = $modelPatient;
					} else 
					{
						Yii::$app->session->setFlash('reservationError');
						return $this->refresh();
					}
				} else 
				{
					if(strcmp($modelPatient->email, $if_exists->email) != 0) {
						$if_exists->email = $modelPatient->email;
						$if_exists->scenario = Patient::SCENARIO_CLIENT;
						if ($if_exists->update() === false) {
							Yii::$app->session->setFlash('reservationError');
							return $this->refresh();
						}
					}
					$model->fk_patient = $if_exists->id_Patient;	
					// $patient_contacts = $modelPatient;
					$patient_contacts = $if_exists;
				}	
				//$model->fk_service = $modelService->fk_id_service;	
				$model->status = Visit::VISIT_UNCONFIRMED;	
				//$model->status = Visit::STATUS_ORDERED;
				//$model->payment = Visit::UNPAID;
				$model->payment = 1;

            	$model->total_price = $modelService->fkIdService->price;
            	$check_free_time = date("H:i", strtotime($model->start_time));
				if (in_array($check_free_time, Visit::getDoctorTimes($model->start_time, $model->fk_user, $modelService->fk_id_service)) && $model->save())
				{
					$modelService->fk_id_visit = $model->id_visit;
					if ($modelService->save()) 							
					{
						$connection = Yii::$app->getDb();
						$query = $connection->createCommand("CREATE EVENT IF NOT EXISTS `name" . $model->id_visit . "`
				           ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL  10 MINUTE
				           DO
				           DELETE FROM `visit` WHERE `status` = 0 AND `id_visit` = " . $model->id_visit . " ");

						$token = \Yii::createObject([
						'class' => TokenPatient::className(),
						'visit_id' => $model->id_visit,
						'patient_id' => $model->fk_patient,
						'type' => TokenPatient::TYPE_CONFIRM_REG,					
						]);
						if (!$token->save(false)) {
							return false;
							Yii::$app->session->setFlash('tokenError');
							return $this->refresh();
						}
						$doctor = Profile::find()->where(['user_id' => $model->fk_user])->one();
						Yii::$app->session->setFlash('confirmationSent');
						Yii::$app->mailer->compose('confirmReservation', ['patient' => $modelPatient, 'visit' => $model, 'doctor' => $doctor, 'token' => $token])
							->setFrom([Yii::$app->params['adminEmail']])
							->setTo($modelPatient->email)
							->setSubject("Rezervacija")
							->send();

						$query->execute();
						
						return $this->refresh();					
					} else 
					{
						Yii::$app->session->setFlash('reservationError');
						return $this->refresh();
					}
				} else 
				{
					die("363");
					Yii::$app->session->setFlash('reservationError');
					return $this->refresh();
				}
			} else 
			{
				Yii::$app->session->setFlash('reservationError');
				return $this->refresh();
			}			
        }
		
        return $this->render('reservation', [
            'model' => $model,
			'modelService' => $modelService,
			'modelPatient' => $modelPatient,
			'service_category_list' => $service_category_list,
			'services_list' => $services_list, 
			'cities_list' => $cities_list,
        ]);
    }
	
	/**
     * Gives back filtered doctors array on chosen service.
     * @return 
     */
	public function actionDoctors($id) 
	{			
		$service = Services::find()
		->where(['id' => $id])->one();
		
		$filtered_docs = User::find()
		->leftJoin('service_assignment', 'service_assignment.user_id = user.id')
		->where(['service_assignment.category_id' => $service->parent_id])
		->all();
		
		$filt_profiles = array();
		foreach ($filtered_docs as $doc) 
		{
			$filt_profiles[] = $doc->profile;
		}
		
		echo "<option value='' disabled selected hidden>Pasirinkite gydytoją…</option>";
		//echo count($doctor) . "\n";
        
        if(count($filt_profiles)>0){
            foreach($filt_profiles as $profile){
                echo "<option value='$profile->user_id'>$profile->name</option>";
            }
        }
        else{
            echo "<option>Sarasas tuscias</option>";
        }
	}
	
	/**
     * Gives back filtered doctors array on chosen service.
     * @return 
     */
	public function actionServices($id) 
	{
		$services = Services::find()->where(['parent_id' => $id])->all();
	
		echo "<option value='' disabled selected hidden>Pasirinkite paslaugą</option>";
		//echo count($doctor) . "\n";
        
        if(count($services)>0 && isset($id)){
            foreach($services as $service){
            	$duration = $service->duration->duration;
            	$dur_for = substr($duration, 0, 5);
                echo "<option value='$service->id'>$service->name ($service->price €) ($dur_for val.)</option>";
            }
        }
        else {
            echo "<option>Sąrašas tuščias</option>";
        }			
	}

    /*
    * Test date selection in reservation page
    */
	public function actionTimes2($date)
	{			
		$begin = new DateTime( '2019-04-04 08:00' );
		$end = new DateTime( '2019-04-04 15:00' );

		$interval = new DateInterval('PT1H');
		$daterange = new DatePeriod($begin, $interval ,$end);

		echo "<option value='' disabled selected hidden>Pasirinkite laiką…</option>";
		//echo count($doctor) . "\n";
        
        if(count($daterange)>0){
            foreach($daterange as $date){
            	$date_format = $date->format('H:i');
                echo "<option value='$date_format'>$date_format</option>";
            }
        }
        else{
            echo "<option>Laisvų laikų nėra</option>";
        }
	}
	
	public function actionTimes($dates, $id, $service)
	{
		//$date = '2019-04-05';
		$date = $dates;
		//$user_id = 7;
		$user_id = $id;
		//$service_id = 5;
		$service_id = $service;
		$break_start = new DateTime($date);
		$break_start_hour = '12:00';
		$break_start->modify($break_start_hour);
		$break_end = new DateTime($date);
		$break_end_hour = '13:00';
		$break_end->modify($break_end_hour);		
		// ------------------------------------------------------------------------
		// find selected service duration and find visits on selected date
		$tomorrow = date('Y-m-d', strtotime($date. ' + 1 days'));
		$duration_obj = ServiceDuration::find()
			->where(['service_id' => $service_id])
			->one();

		$pre_visits = Visit::find()
			->where(['fk_user' => $user_id])
			->andWhere(['>', 'start_time', $date])
			->andWhere(['<', 'start_time', $tomorrow])
			->orderBy(['start_time' => SORT_ASC])
			->all();		
	    $assists = Assists::find()
	        ->where(['fk_user' => $user_id])
	        ->andWhere(['>', 'start_time', $date])
	        ->andWhere(['<', 'start_time', $tomorrow])
	        ->orderBy(['start_time' => SORT_ASC])
	        ->all();
	    $visits = array_merge($pre_visits,$assists);
	    ArrayHelper::multisort($visits, ['start_time'], [SORT_ASC]);
		// ------------------------------------------------------------------------
		// set period start time and end time for calculations		
		$period_start = new DateTime($date);
		$period_start_hour = '08:00';
		$work_end = new DateTime($date);
		$work_end_hour = '18:00';
		$period_start->modify($period_start_hour);
		$work_end->modify($work_end_hour);
		// ------------------------------------------------------------------------

		$duration = $duration_obj->duration;
		list($hours, $minutes) = explode(':', $duration); 
		$total_minutes = $hours * 60 + $minutes;
		$interval = new DateInterval('PT' . $total_minutes . 'M');

		$time_slots = array();
		$count = count($visits);

		if ($count > 0)
		{
			for ($i=0; $i <= $count; $i++) { 
				if ($i == $count) {
					// nuo paskutinio vizito pabaigos iki darbo pabaigos
					$period_start = new DateTime($visits[$i - 1]->end);
					if ($period_start < $break_start) {
						$daterange = new DatePeriod($period_start, $interval , $break_start);
						foreach($daterange as $range){
			            	if (date_add($range, $interval) <= $break_start)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
							}
			            }
						$daterange = new DatePeriod($break_end, $interval , $work_end);
						foreach($daterange as $range){
			            	if (date_add($range, $interval) <= $work_end)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
							}
			            }
					} elseif ($period_start > $break_end) {
						$daterange_last_visit = new DatePeriod($period_start, $interval , $work_end);
			            foreach($daterange_last_visit as $range){
			            	if (date_add($range, $interval) <= $work_end)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
							}
			            }
					} else {
						$daterange = new DatePeriod($break_end, $interval , $work_end);
			            foreach($daterange as $range){
			            	if (date_add($range, $interval) <= $work_end)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
							}
			            }
					}
					//$work_end->modify($work_end_hour);

					/*$daterange_last_visit = new DatePeriod($period_start, $interval , $work_end);
		            foreach($daterange_last_visit as $range){
		            	if (date_add($range, $interval) <= $work_end)
						{
							date_sub($range, $interval);
		            		$time_slots[] = $range->format('H:i');
						}
		            }*/
				} else {
                    // nuo darbo pradzios iki pirmo vizito pr arba nuo i vizito pab iki i+1 pr

                    $period_end = new DateTime($visits[$i]->start_time);

                    if ($period_start >= $break_start && $period_end <= $break_end) {
                        $period_start = new DateTime($visits[$i]->end);
                        continue;
                    }

                    $tmp_period_end = new DateTime($visits[$i]->start_time);
                    $tmp_period_end->sub($interval);

                    $tmp_break_start = new DateTime($date);
                    $tmp_break_start->modify($break_start_hour);
                    $tmp_break_start->sub($interval);

                    if ($period_start <= $break_start && $period_end >= $break_end) {
                        $daterange_before = new DatePeriod($period_start, $interval , $break_start);
                        $daterange_after = new DatePeriod($break_end, $interval , $period_end);
                        foreach($daterange_before as $range){       
                            if ($range <= $tmp_break_start)
                            {
                                $time_slots[] = $range->format('H:i');
                            }
                        }       
                        foreach($daterange_after as $range){        
                            if ($range <= $tmp_period_end)
                            {
                                $time_slots[] = $range->format('H:i');
                            }
                        }   

                        $period_start = new DateTime($visits[$i]->end);

                        continue;

                    }

                    // blogai skaiciuoja slotus, kai intervalas atitinka laiko tarpa
                    /*$period_end->sub($interval);
                    $daterange = new DatePeriod($period_start, $interval , $period_end);
                    if (!empty($daterange)){
                        foreach($daterange as $range){      
                            if ($range <= $break_start)
                            {
                                $time_slots[] = $range->format('H:i');
                                echo $range->format('H:i') . " ideta ties pirmu else " . "\n";
                            } elseif ($range >= $break_end) {
                                $time_slots[] = $range->format('H:i');
                                echo $range->format('H:i') . " ideta ties antru else . i = " . $i . "\n";
                            }
                            $daterange = array();
                        }
                    }*/

                    // ----------------------------------------------------------------------------------------
                    // -- buvo uzkomentuota pries

                    $daterange = new DatePeriod($period_start, $interval , $period_end); // daterange neatimant interval

                    //--$tmp_break_end = new DateTime($date);
                    //--$tmp_break_end->modify($break_end_hour);
                    //--$tmp_break_end->sub($interval);
                    
                    //--if (!empty($daterange)){
                        foreach($daterange as $range){      
                            if ($range <= $tmp_break_start && $range <= $tmp_period_end)
                            {
                                $time_slots[] = $range->format('H:i');
                            } elseif ($range >= $break_end && $range <= $tmp_period_end) {
                                $time_slots[] = $range->format('H:i');                         
                            }
                            //--$daterange = array();
                        }
                    //--}               

                    $period_start = new DateTime($visits[$i]->end);
                }
			}
		} else {			
			$daterange_before_break = new DatePeriod($period_start, $interval ,$break_start);
			$daterange_after_break = new DatePeriod($break_end, $interval ,$work_end);
			//$daterange = new DatePeriod('2019-04-04 08:00', 'PT2H' , '2019-04-04 18:00');
			foreach($daterange_before_break as $range){				
				//var_dump(date_add($range, $interval));
				//die();				
				if (date_add($range, $interval) <= $break_start)
				{
					date_sub($range, $interval);
            		$time_slots[] = $range->format('H:i');
				}
            }
            foreach($daterange_after_break as $range){
            	if (date_add($range, $interval) <= $work_end)
				{
					date_sub($range, $interval);
            		$time_slots[] = $range->format('H:i');
				}
            }
		}

		echo "<option value='' disabled selected hidden>Pasirinkite laiką…</option>";
        if(count($time_slots)>0){
            foreach($time_slots as $slot){
                echo "<option value='$slot'>" . $slot . "</option>";
            }
        }
        else{
            //echo "<option>Visi laikai užimti</option>";
            echo "<option value='' disabled selected hidden>Visi laikai užimti</option>";
        }
        /*return $this->render('times', [
			'time_slots' => $time_slots,
			'visits' => $visits,
			'duration_obj' => $duration_obj,
        ]); */
	}

	/*
	* Clear times dropdown list
	*/
	public function actionClearTimes() 
	{
		echo "<option disabled selected hidden>Pasirinkite laiką…</option>";
	}		

	/*
	* Clear times dropdown list
	*/
	public function actionClearDate() 
	{
		echo "<option disabled selected hidden>Pasirinkite dieną</option>";
	}

	/*
	* Clear times dropdown list
	*/
	public function actionClearDoctors() 
	{
		echo "<option disabled selected hidden>Pasirinkite gydytoją</option>";
	}

	/*
	* Confirm registration
	*/
	public function actionConfirm($code)
	{
		//$token = TokenPatient::find()->where(['patient_id' => $patient_id, 'code' => $code, 'type' => TokenPatient::TYPE_CONFIRM_REG])->one();
		$token = TokenPatient::find()->where(['code' => $code, 'type' => TokenPatient::TYPE_CONFIRM_REG])->one();
        if (empty($token) || ! $token instanceof TokenPatient) {
        	//Yii::$app->session->setFlash('confirmTokenExpired');

        	return $this->render('confirm');
			//throw new NotFoundHttpException();
        }
		if ($token === null || $token->isExpired) {			
            //$this->trigger(self::EVENT_AFTER_TOKEN_VALIDATE, $event);
            //Yii::$app->session->setFlash('confirmTokenExpired');

            return $this->render('confirm');
        }
		
		//$visit = Visit::find()->where(['id_visit' => $visit_id])->one();
		$visit = Visit::find()->where(['id_visit' => $token->visit_id])->one();
		if (!($visit)) {
				Yii::$app->session->setFlash('visitNotFound');
				return $this->refresh();
		}
		//if (!$token->delete()){
        //    return false;
		//}
		$visit->status = Visit::VISIT_CONFIRMED;
		if ($visit->update()){
			\Yii::$app->session->setFlash('registrationConfirmed');

            return $this->refresh();
		}
		
        /* $model = new CancelForm();
		if ($model->load(Yii::$app->request->post())) {
            //Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } */
		
		return $this->render('confirm');
	}

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	/**
     * Displays languages.
     *
     * @return string
     */
    public function actionLanguage($lang)
    {
    	/**
        if(isset($_POST['lang'])) {
			Yii::$app->language = $_POST['lang'];	
			
			
			/**
			$cookie = new yii\web\Cookie([
				'name' => 'lang',
				'value' => $_POST['lang']
			]);
			
			Yii::$app->getResponse()->getCookie()->add($cookie);
			*/
		//}
		Yii::$app->language = $lang;
		Yii::$app->session->set('lang', $lang);
    }

    public function beforeAction($action) {
	    if (Yii::$app->session->has('lang')) {
	        Yii::$app->language = Yii::$app->session->get('lang');
	    } else {
	        //or you may want to set lang session, this is just a sample
	        Yii::$app->language = 'lt';
	    }
	    return parent::beforeAction($action);
	}
	
	/** 
     *  TEMPORARY Creates a new Visit model for guest reservation.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionReservationcopy()
    {		
    	$cities = Cities::find()->all();
    	$cities_list = ArrayHelper::map($cities, 'id', 'name');
    	//$service_category = Services::find()->where(['parent_id' => 0])->all();
    	$service_category = ServiceCategory::find()->all();
    	$service_category_list = ArrayHelper::map($service_category, 'id', 'parent_name');
    	$services = Services::find()->all();
    	$services_list = ArrayHelper::map($services, 'id', 'name');
		
		$model = new Visit();
		$model->scenario = Visit::SCENARIO_AUTO;

		$modelService = new OrderedService();
		$modelPatient = \Yii::createObject([
            'class'    => Patient::className(),
            'scenario' => Patient::SCENARIO_AUTO,
        ]);	
		// loading models from reservation page form. Converting selected date to minutes and then add time
        if ($model->load(Yii::$app->request->post()) && $modelService->load(Yii::$app->request->post())) {
			$duration = ServiceDuration::find()
			->where(['service_id' => $modelService->fk_id_service])
			->one();
				
			$model->tmptime = $model->time;
			$minutes = 0; 
			if (strpos($model->tmptime, ':') !== false) 
			{ 
				// Split hours and minutes. 
				list($model->tmptime, $minutes) = explode(':', $model->tmptime); 
			} 
			$start_time_minutes =  $model->tmptime * 60 + $minutes;			
			
			$model->start_time = date('Y-m-d H:i:s',strtotime($model->tmpdate . '+ '. $start_time_minutes .' minutes'));	

			$minutes = 0; 
			$duration_m = $duration->duration;
			if (strpos($duration_m, ':') !== false) 
			{ 
				// Split hours and minutes. 
				list($duration_m, $minutes) = explode(':', $duration_m); 
			} 
			$duration_minutes =  $duration_m * 60 + $minutes;
			
			$model->end = date('Y-m-d H:i:s',strtotime($model->start_time . '+ '. $duration_minutes .' minutes'));	
			
			if ($modelPatient->load(Yii::$app->request->post())) 
			{
				$if_exists = Patient::findOne([
					'name' => $modelPatient->name,
					'surname' => $modelPatient->surname,
					'code' => $modelPatient->code,
				]);
				$patient_contacts;
				if (is_null($if_exists)) 
				{
					if ($modelPatient->save())
					{
						$model->fk_patient = $modelPatient->id_Patient;
						$patient_contacts = $modelPatient;
					} else 
					{
						Yii::$app->session->setFlash('reservationError');
						return $this->refresh();
					}
				} else 
				{
					if(strcmp($modelPatient->email, $if_exists->email) != 0) {
						$if_exists->email = $modelPatient->email;
						$if_exists->scenario = Patient::SCENARIO_CLIENT;
						if ($if_exists->update() === false) {
							Yii::$app->session->setFlash('reservationError');
							return $this->refresh();
						}
					}
					$model->fk_patient = $if_exists->id_Patient;	
					// $patient_contacts = $modelPatient;
					$patient_contacts = $if_exists;
				}	
				//$model->fk_service = $modelService->fk_id_service;	
				$model->status = Visit::VISIT_UNCONFIRMED;	
				//$model->status = Visit::STATUS_ORDERED;
				//$model->payment = Visit::UNPAID;
				$model->payment = 1;

            	$model->total_price = $modelService->fkIdService->price;
				if ($model->save())
				{
					$modelService->fk_id_visit = $model->id_visit;
					if ($modelService->save()) 							
					{
						$connection = Yii::$app->getDb();
						$query = $connection->createCommand("CREATE EVENT IF NOT EXISTS `name" . $model->id_visit . "`
				           ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL  10 MINUTE
				           DO
				           DELETE FROM `visit` WHERE `status` = 0 AND `id_visit` = " . $model->id_visit . " ");

						$token = \Yii::createObject([
						'class' => TokenPatient::className(),
						'visit_id' => $model->id_visit,
						'patient_id' => $model->fk_patient,
						'type' => TokenPatient::TYPE_CONFIRM_REG,					
						]);
						if (!$token->save(false)) {
							return false;
							Yii::$app->session->setFlash('tokenError');
							return $this->refresh();
						}
						$doctor = Profile::find()->where(['user_id' => $model->fk_user])->one();
						Yii::$app->session->setFlash('confirmationSent');
						Yii::$app->mailer->compose('confirmReservation', ['patient' => $modelPatient, 'visit' => $model, 'doctor' => $doctor, 'token' => $token])
							->setFrom([Yii::$app->params['adminEmail']])
							->setTo($modelPatient->email)
							->setSubject("Rezervacija")
							->send();

						$query->execute();
						
						return $this->refresh();					
					} else 
					{
						Yii::$app->session->setFlash('reservationError');
						return $this->refresh();
					}
				} else 
				{
					Yii::$app->session->setFlash('reservationError');
					return $this->refresh();
				}
			} else 
			{
				Yii::$app->session->setFlash('reservationError');
				return $this->refresh();
			}			
        }
		
        return $this->render('reservationcopy', [
            'model' => $model,
			'modelService' => $modelService,
			'modelPatient' => $modelPatient,
			'service_category_list' => $service_category_list,
			'services_list' => $services_list, 
			'cities_list' => $cities_list,
        ]);
    }
}
