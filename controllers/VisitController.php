<?php

namespace app\controllers;

use Yii;
use app\models\Vacations;
use app\models\Patient;
use app\models\Visit;
use app\models\Assists;
use app\models\VisitPayment;
use app\models\ServiceCategory;
use app\models\ServiceDuration;
use app\models\Services;
use app\models\OrderedService;
use app\models\VisitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dektrium\user\models\User;
use yii\filters\AccessControl;

/**
 * VisitController implements the CRUD actions for Visit model.
 */
class VisitController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'filtered-index', 'calendar', 'timetable', 
					'view', 'view-tmp', 'create', 'create-tmp', 'update', 'update-tmp', 'find-model', 'visits-list'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'filtered-index', 'calendar', 'timetable', 'view', 'view-tmp', 'create', 
                            'create-tmp', 'update', 'update-tmp', 'find-model'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['visits-list'],
                        'roles' => ['assistant'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Visit models.
     * @return mixed
     */
    public function actionTimetable()
    {                
        $assistants = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->where(['=', 'auth_assignment.item_name', 'assistant'])
            ->all();
        $assistants_id = array();
        foreach ($assistants as $assistant) {
            $assistants_id[] = $assistant->id;
        }

        $assists = Assists::find()->all();

        $visits = Visit::find()->all();
        //$doctors = User::find()->where(['>', 'id', 4])->andWhere(['!=', 'id', \Yii::$app->user->id])->all();
        $doctors = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->where(['=', 'auth_assignment.item_name', 'assistant'])
            ->orWhere(['=', 'auth_assignment.item_name', 'doctor'])
            ->orderBy(['user.id' => SORT_ASC])
            ->all();
        $doctor_online = User::find()->where(['id' => \Yii::$app->user->id])->one();

        foreach ($assists as $assist) {            
            $Assist = new \yii2fullcalendarscheduler\models\Event();
            $Assist->id = $assist->id_assist;

            $Assist->start = $assist->start_time;
            $Assist->end = $assist->end;
            $Assist->resourceId = $assist->fk_user;
            $Assist->url = Url::to(['/assists/update', 'id' => $assist->id_assist]);  
            $Assist->title = $assist->info;
            
            $Assist->nonstandard = [
                'info' => $assist->info,
                'poptitle' => $assist->fkUser->profile->name,
                'popcontent' => $assist->info,
            ];
            $Assist->textColor = '#404040';
            $Assist->backgroundColor = '#80f442';

            $tasks[] = $Assist;

        }

        foreach ($visits as $vis) {            
            $Visit = new \yii2fullcalendarscheduler\models\Event();
            $Visit->id = $vis->id_visit;
            //$Visit->editable = true;
            //$Visit->title = $vis->fk_patient . "\n" . $vis->info;
            //$Visit->title = $vis->fk_patient . "\n" . $vis->info;
            
            //$Visit->title = Visit::getPatientName($vis->id_visit) . "\n" . $vis->info;
            
            //var_dump(gettype(Visit::getPatientName($vis->id_visit)));

            //$patient = Visit::getPatientName($vis->id_visit);

            if (!is_null($patient = $vis->patient))
            {

                //$patientName = Visit::getPatientName($vis->id_visit)->name;
                $patientName = $patient->name;
                //$patientSurname = Visit::getPatientName($vis->id_visit)->surname;
                $patientSurname = $patient->surname;
                $duration = strtotime($vis->services[0]->duration->duration);
                $duration_format = date('H:i', $duration);
                if (empty($vis->services))
                {
                    $Visit->title = $patientName . " " . $patientSurname . "\n" . $vis->info;
                } else 
                {
                    $Visit->title = $patient->card_number . "\n" . $patientName . " " . $patientSurname . "\n" . $vis->services[0]->name . "\nTrukmė: " . $duration_format . " val.";
                }
                $Visit->start = $vis->start_time;
                $Visit->end = $vis->end;
                $Visit->resourceId = $vis->user->id;
                $Visit->url = Url::to(['/visit/update', 'id' => $vis->id_visit]);  
                
                $Visit->nonstandard = [
                    'info' => $vis->room,
                    'poptitle' => $patientName . " " . $patientSurname,
                    'popcontent' => 'Kortelės nr. ' . $patient->card_number . ".\n" . $patientName . " " . $patientSurname . ".\n" . $vis->services[0]->name . ".\nTrukmė: " . $duration_format . " val." . "\n" . "\nKabinetas - " .$vis->room,
                ];
                $Visit->textColor = '#404040';
                if ($vis->status == 0) $Visit->borderColor = 'red';
                switch ($vis->payment)
                {
                    case 2:                    
                    $Visit->backgroundColor = '#41c4f4';
                    break;
                    case 3:                    
                    $Visit->backgroundColor = '#41f4c4';
                    break;
                    case 4:                    
                    $Visit->backgroundColor = '#ca41f4';
                    break;
                    case 5:                    
                    $Visit->backgroundColor = '#f49141';
                    break;
                    default:
                    $Visit->backgroundColor = '#80f442';
                }

                $tasks[] = $Visit;
            }
        }

        return $this->render('timetable', [
            'visits' => $tasks,
            'doctors' => $doctors,
            'doctor_online' => $doctor_online,
            'assistants_id' => $assistants_id,
            'assistants' => $assistants,
        ]);
    }

    /**
     * Lists all Visit models.
     * @return mixed
     */
    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    /**
     * Lists all Visit models.
     * @return mixed
     */
    public function actionVisitsList()
    {               
        $searchModel = new VisitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('visitslist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Visit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $visits = Visit::find()->all();
		$tasks = [];

        $doctors = User::find()->where(['>', 'id', 5])->andWhere(['!=', 'id', \Yii::$app->user->id])->all();

        $doctor_online = User::find()->where(['id' => \Yii::$app->user->id])->one();
		
		foreach ($visits as $vis) {            
			$Visit = new \yii2fullcalendar\models\Event();
			$Visit->id = $vis->id_visit;
			//$Visit->editable = true;
			//$Visit->title = $vis->fk_patient . "\n" . $vis->info;
			//$Visit->title = $vis->fk_patient . "\n" . $vis->info;
			
			//$Visit->title = Visit::getPatientName($vis->id_visit) . "\n" . $vis->info;
			
			//var_dump(gettype(Visit::getPatientName($vis->id_visit)));

			//$patient = Visit::getPatientName($vis->id_visit);

            if (!is_null($patient = $vis->patient))
            {

                //$patientName = Visit::getPatientName($vis->id_visit)->name;
                $patientName = $patient->name;
                //$patientSurname = Visit::getPatientName($vis->id_visit)->surname;
                $patientSurname = $patient->surname;
                $duration = strtotime($vis->services[0]->duration->duration);
                $duration_format = date('H:i', $duration);
                if (empty($vis->services))
                {
                    $Visit->title = $patientName . " " . $patientSurname . "\n" . $vis->info;
                } else 
                {
                    $Visit->title = $patient->card_number . "\n" . $patientName . " " . $patientSurname . "\n" . $vis->services[0]->name . "\nTrukmė: " . $duration_format . " val.";
                }
                
                $Visit->nonstandard = [
                    'info' => $vis->info,
                    'room' => $vis->room,
                    //'service' => $vis->services[0]->name,
                    'payment' => $vis->payment,
                ];
                $Visit->start = $vis->start_time;
                $Visit->end = $vis->end;
                $Visit->resourceId = $vis->user->profile->name;
                switch ($vis->payment)
                {
                    case 2:                    
                    $Visit->backgroundColor = '#41c4f4';
                    break;
                    case 3:                    
                    $Visit->backgroundColor = '#41f4c4';
                    break;
                    case 4:                    
                    $Visit->backgroundColor = '#ca41f4';
                    break;
                    case 5:                    
                    $Visit->backgroundColor = '#f49141';
                    break;
                    default:
                    $Visit->backgroundColor = '#80f442';
                }

                $tasks[] = $Visit;
            }
		}

        return $this->render('index', [
            'visits' => $tasks,
            'doctors' => $doctors,
            'doctor_online' => $doctor_online,
        ]);
    }

    /**
     * Displays a single Visit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->request->referrer == Url::toRoute(['visits-list'], true))
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Visit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewVisit($id)
    {
        return $this->render('viewvisit', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Visit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewTmp($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date, $id)
    {
        //$service_category = ServiceCategory::find()->all();
        $service_category = ServiceCategory::getDoctorCategories($id);
        $service_category_list = ArrayHelper::map($service_category, 'id', 'parent_name');

        $patients = Patient::find()->all();
        $patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }
        $hierarchy = Services::getHierarchy();
        $visit_payment = VisitPayment::find()->all();
        $visit_status = ArrayHelper::map($visit_payment, 'id', 'name');

        $model = new Visit();
        $model->scenario = Visit::SCENARIO_DOCTOR;

        $modelService = new OrderedService();
        $model->start_time = date('Y-m-d H:i', strtotime($date));
        $model->fk_user = $id;

        if ($model->load(Yii::$app->request->post()) && $modelService->load(Yii::$app->request->post())) {            
            $model->status = Visit::VISIT_CONFIRMED;

            $duration = ServiceDuration::find()
            ->where(['service_id' => $modelService->fk_id_service])
            ->one();

            //$model->total_price = $modelService->fkIdService->price;

            $minutes = 0; 
            $duration_m = $duration->duration;
            if (strpos($duration_m, ':') !== false) 
            { 
                // Split hours and minutes. 
                list($duration_m, $minutes) = explode(':', $duration_m); 
            } 
            $duration_minutes =  $duration_m * 60 + $minutes;

            $model->end = date('Y-m-d H:i',strtotime($model->start_time . '+ '. $duration_minutes .' minutes'));  

            if ($model->save())                
            {
                $modelService->fk_id_visit = $model->id_visit;
                if ($modelService->save())
                {
                    //return $this->redirect(['view', 'id' => $model->id_visit]);
                    return $this->redirect(['timetable']);
                }                
            } else {
                throw new NotFoundHttpException();
            }

        }

        $this->view->title = Yii::t('app', 'Create Visit');

        return $this->renderAjax('create', [
            'model' => $model,
            'hierarchy' => $hierarchy,
            'modelService' => $modelService,
            'visit_status' => $visit_status,
            'patients_list' => $patients_list,
            'service_category_list' => $service_category_list,
        ]);
		
		
		/**
		$model = new Visit();
		//$model->start_time = $start;
		
		if($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->renderAjax('create', ['model' -> $model,]);
		}
		*/
    }

    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePartial($date, $id)
    {
        $service_category = ServiceCategory::find()->all();
        $service_category_list = ArrayHelper::map($service_category, 'id', 'parent_name');

        $patients = Patient::find()->all();
        $patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }
        $hierarchy = Services::getHierarchy();
        $visit_payment = VisitPayment::find()->all();
        $visit_status = ArrayHelper::map($visit_payment, 'id', 'name');

        $model = new Visit();
        $model->scenario = Visit::SCENARIO_DOCTOR;

        $modelService = new OrderedService();
        $model->start_time = date('Y-m-d H:i', strtotime($date));
        $model->fk_user = $id;

        if ($model->load(Yii::$app->request->post()) && $modelService->load(Yii::$app->request->post())) {            
            $model->status = Visit::VISIT_CONFIRMED;

            $duration = ServiceDuration::find()
            ->where(['service_id' => $modelService->fk_id_service])
            ->one();

            //$model->total_price = $modelService->fkIdService->price;

            $minutes = 0; 
            $duration_m = $duration->duration;
            if (strpos($duration_m, ':') !== false) 
            { 
                // Split hours and minutes. 
                list($duration_m, $minutes) = explode(':', $duration_m); 
            } 
            $duration_minutes =  $duration_m * 60 + $minutes;

            $model->end = date('Y-m-d H:i',strtotime($model->start_time . '+ '. $duration_minutes .' minutes'));  

            if ($model->save())                
            {
                $modelService->fk_id_visit = $model->id_visit;
                if ($modelService->save())
                {
                    //return $this->redirect(['view', 'id' => $model->id_visit]);
                    return $this->redirect(['timetable']);
                }                
            } else {
                throw new NotFoundHttpException();
            }

        }

        $this->view->title = Yii::t('app', 'Create Visit');

        return $this->ajaxResponse(false, $this->renderPartial('_form', [
            'model' => $model,
            'hierarchy' => $hierarchy,
            'modelService' => $modelService,
            'visit_status' => $visit_status,
            'patients_list' => $patients_list,
            'service_category_list' => $service_category_list,
        ]));
    }

    private function ajaxResponse($success = true, $content = '')
    {
        $response = [
            'success' => $success,
            'content' => $content,
        ];
        //echo json_encode($response);
        //return $success;
        return json_encode($response);
    }
    
    /**
     * Gives back filtered doctors array on chosen service.
     * @return 
     */
    public function actionEndTime($start_time, $fk_id_service) 
    {
        $duration_minutes = Visit::getDurationMinutes($fk_id_service);
        $end_time = date('Y-m-d H:i',strtotime($start_time . '+ '. $duration_minutes .' minutes'));

        return $end_time;
    }
    
    /**
     * Gives back filtered doctors array on chosen service.
     * @return 
     */
    public function actionPrice($id) 
    {
        $service = Services::find()->where(['id' => $id])->one();        
        
        if(count($service)>0 && isset($id)){
                return $service->price;
        }
        else {
            echo "<input />0.00 €</br>";
        }           
    }

    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateTmp()
    {
        $patients = Patient::find()->all();
        $patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }
        $hierarchy = Services::getHierarchy();
        $visit_status = VisitPayment::find()->all();
        $status_array = ArrayHelper::map($visit_status, 'id', 'name');
        $model = new Visit();
        $modelService = new OrderedService();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_visit]);
        }

        return $this->render('create', [
            'model' => $model,
            'hierarchy' => $hierarchy,
            'modelService' => $modelService,
            'status_array' => $status_array,
            'patients_list' => $patients_list,
        ]);
        
        
        /**
        $model = new Visit();
        //$model->start_time = $start;
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', ['model' -> $model,]);
        }
        */
    }

    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAssist($date, $id)
    {        
        $doctors = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->where(['=', 'auth_assignment.item_name', 'doctor'])
            ->all();

        $doctors_list = [];
        foreach ($doctors as $doctor) {
            $doctors_list[$doctor->id] = $doctor->profile->name;
        }

        $model = new Visit();
        $model->scenario = Visit::SCENARIO_ASSIST;
        $model->room = VISIT::ROOM;

        $model->start_time = date('Y-m-d H:i', strtotime($date));

        if ($model->load(Yii::$app->request->post())) {            
            $model->status = Visit::VISIT_CONFIRMED;
            $model->fk_user = $id;
            if ($model->save())                
            {
                //return $this->redirect(['view', 'id' => $model->id_visit]);
                return $this->redirect(['timetable']);              
            }

        }

        return $this->renderAjax('assist', [
            'model' => $model,
            'doctors_list' => $doctors_list,
        ]);
    }

    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDoctorAssist($date, $id)
    {

        $model = new Assists();

        $model->start_time = date('Y-m-d H:i', strtotime($date));

        if ($model->load(Yii::$app->request->post())) {  
            $model->fk_user = $id;
            if ($model->save())                
            {
                //return $this->redirect(['view', 'id' => $model->id_visit]);
                return $this->redirect(['timetable']);              
            }

        }

        return $this->renderPartial('assist/_formassist', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Visit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $service_category = ServiceCategory::find()->all();
        $service_category_list = ArrayHelper::map($service_category, 'id', 'parent_name');
        
        $patients = Patient::find()->all();
        $patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }
        $hierarchy = Services::getHierarchy();
        $visit_payment = VisitPayment::find()->all();
        $visit_status = ArrayHelper::map($visit_payment, 'id', 'name');
        $model = $this->findModel($id);
        $model->scenario = Visit::SCENARIO_DOCTOR;
        $modelService = OrderedService::find()->where(['fk_id_visit' => $model->id_visit])->one();

        $services = Services::find()->where(['parent_id' => $modelService->fkIdService->parent_id])->all();
        $services_list = ArrayHelper::map($services, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $modelService->load(Yii::$app->request->post())) {

            $duration_minutes = Visit::getDurationMinutes($modelService->fk_id_service);
            $model->end = date('Y-m-d H:i',strtotime($model->start_time . '+ '. $duration_minutes .' minutes')); 

            if ($model->save() && $modelService->save()) {
                //return $this->redirect(['view', 'id' => $model->id_visit]);
                return $this->redirect(['timetable']);
            }            
        }

        return \Yii::$app->user->can('manageVisits') ? $this->render('update', [
            'model' => $model,
            'hierarchy' => $hierarchy,
            'modelService' => $modelService,
            'visit_status' => $visit_status,
            'patients_list' => $patients_list,
            'service_category_list' => $service_category_list,
            'services_list' => $services_list,
        ]) : $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Visit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateTmp($id)
    {
        $patients = Patient::find()->all();
        $patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }
        $hierarchy = Services::getHierarchy();
        $visit_payment = VisitPayment::find()->all();
        $visit_status = ArrayHelper::map($visit_payment, 'id', 'name');
        $model = $this->findModel($id);
        $modelService = OrderedService::find()->where(['fk_id_visit' => $model->id_visit])->one();        

        if ($model->load(Yii::$app->request->post()) && $modelService->load(Yii::$app->request->post()) && $model->save() && $modelService->save()) {
            //return $this->redirect(['view', 'id' => $model->id_visit]);
            return $this->redirect(['view-tmp', 'id' => $model->id_visit]);
        }

        return $this->render('update-tmp', [
            'model' => $model,
            'hierarchy' => $hierarchy,
            'modelService' => $modelService,
            'visit_status' => $visit_status,
            'patients_list' => $patients_list,
        ]);
    }

    /**
     * Deletes an existing Visit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['timetable']);
    }

    /**
     * Find unavailable days.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUnavailable($doc_id, $service_id) {
        $vacations = Vacations::getDoctorVacations($doc_id);  

        $unavailable_days = array();
        $visits = Visit::getDoctorVisits($doc_id);

        $a = "a";
        $i = 1;

        if (!empty($visits)){
            //$visits_map = ArrayHelper::map($visits, 'start_time', 'end', 'start_format');
            $visits_map = ArrayHelper::map($visits, 'start_time', 'end', 'start_format');
            foreach ($visits_map as $key => $value) {
                $time_slots = Visit::getDoctorTimes($key, $doc_id, $service_id);
                if (empty($time_slots)) {
                    $unavailable_days[$a . $i] = $key;
                    $i++;
                }
            }
        }
        if (!empty($vacations)) {
            foreach ($vacations as $vacation) {
                $unavailable_days[$a . $i] = $vacation;
                $i++;
            }                
        }
        
        echo json_encode($unavailable_days);
    }

    /**
     * Finds the Visit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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
}
