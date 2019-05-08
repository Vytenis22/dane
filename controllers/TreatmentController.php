<?php

namespace app\controllers;

use Yii;
use app\models\Treatment;
use app\models\TreatmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TreatmentController implements the CRUD actions for Treatment model.
 */
class TreatmentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Treatment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TreatmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Treatment model.
     * @param integer $id_treatment
     * @param integer $fk_id_service
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_treatment, $fk_id_service)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_treatment, $fk_id_service),
        ]);
    }

    /**
     * Creates a new Treatment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Treatment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_treatment' => $model->id_treatment, 'fk_id_service' => $model->fk_id_service]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Treatment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_treatment
     * @param integer $fk_id_service
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_treatment, $fk_id_service)
    {
        $model = $this->findModel($id_treatment, $fk_id_service);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_treatment' => $model->id_treatment, 'fk_id_service' => $model->fk_id_service]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Treatment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_treatment
     * @param integer $fk_id_service
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_treatment, $fk_id_service)
    {
        $this->findModel($id_treatment, $fk_id_service)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Treatment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_treatment
     * @param integer $fk_id_service
     * @return Treatment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_treatment, $fk_id_service)
    {
        if (($model = Treatment::findOne(['id_treatment' => $id_treatment, 'fk_id_service' => $fk_id_service])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
