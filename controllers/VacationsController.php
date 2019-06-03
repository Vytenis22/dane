<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\models\Vacations;
use app\models\VacationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * VacationsController implements the CRUD actions for Vacations model.
 */
class VacationsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'my-vacations', 'update', 'create', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['my-vacations', 'update', 'create'],
                        'roles' => ['assistant'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Vacations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VacationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Vacations models.
     * @return mixed
     */
    public function actionMyVacations()
    {
        $searchModel = new VacationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, \Yii::$app->user->id);

        return $this->render('myvacations', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vacations model.
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
     * Creates a new Vacations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vacations();

        $today = date('Y-m-d');
        $confirmed_vacations = Vacations::find()->where(['fk_user' => \Yii::$app->user->id])
            ->andWhere(['=', 'status', Vacations::CONFIRMED])
            ->andWhere(['>', 'begin', $today])
            ->all();

        $unavailable_days = Vacations::getUnavailableVacations(\Yii::$app->user->id);

        $model->scenario = Vacations::SCENARIO_DOCTOR;
        $model->fk_user = \Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            foreach ($confirmed_vacations as $vacation) {
                if ($model->begin < $vacation->begin && $model->end > $vacation->end)
                {
                    Yii::$app->session->setFlash('unavailableVacations');
                    return $this->redirect(['my-vacations']);
                }
            }
            if ($model->begin && $model->end )
            $model->created_at = date('Y-m-d H:i');
            if ($model->save()) {
                return $this->redirect(['my-vacations']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'unavailable_days' => $unavailable_days,
        ]);
    }

    /**
     * Creates a new Vacations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateVac()
    {
        $model = new Vacations();

        $doctors_list = Vacations::getEmployees();

        $model->scenario = Vacations::SCENARIO_ADMIN;
        $model->fk_admin = \Yii::$app->user->id;
        $model->status = Vacations::CONFIRMED;    

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = date('Y-m-d H:i');
            $model->confirmed_at = date('Y-m-d H:i');
            if ($model->save())
            {
                return $this->redirect(['index']);
            }            
        }

        return $this->render('createAdmin', [
            'model' => $model,
            'doctors_list' => $doctors_list,
        ]);
    }

    /**
     * Creates a new Vacations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);

        $model->confirm();

        return $this->redirect(['index']);
    }

    /**
     * Creates a new Vacations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);

        $model->reject();

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Vacations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->fk_user != \Yii::$app->user->id || empty($model))
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $unavailable_days = Vacations::getUnavailableVacations($model->fk_user);

        $model->scenario = Vacations::SCENARIO_DOCTOR;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['my-vacations']);
        }

        return $this->render('update', [
            'model' => $model,
            'unavailable_days' => $unavailable_days,
        ]);
    }

    /**
     * Updates an existing Vacations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateVac($id)
    {
        $model = $this->findModel($id);

        if (empty($model))
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $doctors_list = Vacations::getEmployees();
        $status_list = Vacations::getStatusList();

        if (\Yii::$app->user->can('confirmVacations'))
        {
            $model->scenario = Vacations::SCENARIO_ADMIN;
            $model->fk_admin = \Yii::$app->user->id;
            $model->status = Vacations::CONFIRMED;            
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->confirmed_at = date('Y-m-d H:i');
            if ($model->save())
            {
                return $this->redirect(['index']);
            }            
        }

        return $this->render('updateAdmin', [
            'model' => $model,
            'doctors_list' => $doctors_list,
            'status_list' => $status_list,
        ]);
    }

    /**
     * Deletes an existing Vacations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return Yii::$app->request->referrer == Url::toRoute(['my-vacations'], true) ? $this->redirect(['my-vacations']) : 
            $this->redirect(['index']);
    }

    /**
     * Finds the Vacations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vacations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vacations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
