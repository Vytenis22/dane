<?php

namespace app\controllers;

use Yii;
use app\models\Patient;
use app\models\PatientSearch;
use app\models\Cities;
use app\models\Visit;
use app\models\VisitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * PatientController implements the CRUD actions for Patient model.
 */
class PatientController extends Controller
{	
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            /* 'access' => [
                'class' => AccessControl::className(),
				'only' => ['*'],
				'rules' => [
					'allow' => true,
					'actions' => [
						'index', 'view', 'update',
						'delete' => ['POST'],
					],
					'roles' => ['@'],
				]
                
            ], */
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'findModel', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update', 'index', 'view', 'view-patient', 'findModel'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'delete'],
                        'roles' => ['doctor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Patient models.
     * @return mixed
     */
    public function actionIndex()
    {
		$countedPatients = Patient::patients();
        $searchModel = new PatientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'patient' => $countedPatients,
        ]);
    }

    /**
     * Lists all patient's visits.
     * @return mixed
     */
    public function actionVisits($id)
    {
        if ($id != \Yii::$app->user->id)                    
        {
            if (\Yii::$app->user->can('viewVisit'))
            {
                $searchModel = new VisitSearch();
                $dataProvider = $searchModel->searchPatient(Yii::$app->request->queryParams, $id);

                return $this->render('visits', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $searchModel = new VisitSearch();
        $dataProvider = $searchModel->searchPatient(Yii::$app->request->queryParams, $id);

        return $this->render('visits', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Patient model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Patient model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewPatient($id)
    {
        $userId = Patient::find()->where('fk_user=:id', [':id' => $id])->one();
        if (empty($userId))
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        if ($id != \Yii::$app->user->id)                    
        {
            if (\Yii::$app->user->can('viewVisit'))
            {
                return $this->render('viewpatient', [
                    'model' => $this->findPatient($id),
                ]);
            } else
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->render('viewpatient', [
            'model' => $this->findPatient($id),
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $cities = Cities::find()->all();
        $cities_list = ArrayHelper::map($cities, 'id', 'name');
        //$model = new Patient();
		$model = \Yii::createObject([
            'class'    => Patient::className(),
            'scenario' => Patient::SCENARIO_CREATE,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Patient]);
        }

        return $this->render('create', [
            'model' => $model,
            'cities_list' => $cities_list,
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePatient($id)
    {
        $cities = Cities::find()->all();
        $cities_list = ArrayHelper::map($cities, 'id', 'name');
        //$model = new Patient();
        $model = \Yii::createObject([
            'class'    => Patient::className(),
            'scenario' => Patient::SCENARIO_CREATE,
        ]);

        $model->fk_user = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['viewpatient', 'id' => $model->id_Patient]);
        }

        return $this->render('createpatient', [
            'model' => $model,
            'cities_list' => $cities_list,
        ]);
    }

    /**
     * Updates an existing Patient model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {       
        $cities = Cities::find()->all();
        $cities_list = ArrayHelper::map($cities, 'id', 'name');

        $model = $this->findModel($id);
        $model->scenario = Patient::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return \Yii::$app->user->can('viewVisit') ? $this->redirect(['view', 'id' => $model->id_Patient]) : $this->redirect(['view-patient', 'id' => \Yii::$app->user->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'cities_list' => $cities_list,
        ]);
    }

    /**
     * Deletes an existing Patient model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Patient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Patient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Patient::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the Patient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Patient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPatient($id)
    {
        /*if (($model = Patient::find()->where(['fk_user' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));*/

        $model = Patient::find()->where(['fk_user' => $id])->one();

        return $model;
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
