<?php

namespace app\controllers;

use Yii;
use app\models\TreatmentPlans;
use app\models\Patient;
use app\models\TreatmentPlansSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TreatmentPlansController implements the CRUD actions for TreatmentPlans model.
 */
class TreatmentPlansController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'find-model'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'find-model'],
                        'roles' => ['doctor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all TreatmentPlans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TreatmentPlansSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all TreatmentPlans models.
     * @return mixed
     */
    public function actionFilteredIndex($id_Patient)
    {
        $model = Patient::find()->where(['id_Patient' => $id_Patient])->one();
        if (empty($model)) 
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $searchModel = new TreatmentPlansSearch();
        $dataProvider = $searchModel->searchFiltered(Yii::$app->request->queryParams, $id_Patient);
        if ($model->fk_user != \Yii::$app->user->id)                    
        {
            if (\Yii::$app->user->can('manageVisits'))
            {
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'id_Patient' => $id_Patient,
                    'model' => $model,
                ]);
            } else
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_Patient' => $id_Patient,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TreatmentPlans model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $id_Patient)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'id_Patient' => $id_Patient,
        ]);
    }

    /**
     * Creates a new TreatmentPlans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_Patient)
    {
        /*$patients = Patient::find()->all();
        $patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }*/
        $model = new TreatmentPlans();

        $model->fk_patient = $id_Patient;
        //$model->fk_user = \Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_Patient' => $model->fk_patient]);
        }

        return $this->render('create', [
            'model' => $model,
            'id_Patient' => $id_Patient,
        ]);
    }

    /**
     * Updates an existing TreatmentPlans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $id_Patient)
    {
        $patients = Patient::find()->all();
        $patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_Patient' => $model->fk_patient]);
        }

        return $this->render('update', [
            'model' => $model,
            'id_Patient' => $id_Patient,  
            'patients_list' => $patients_list,          
        ]);
    }

    /**
     * Deletes an existing TreatmentPlans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $id_Patient)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 
            'id_Patient' => $id_Patient,]);
    }

    /**
     * Finds the TreatmentPlans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TreatmentPlans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TreatmentPlans::findOne($id)) !== null) {
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
