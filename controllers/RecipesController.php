<?php

namespace app\controllers;

use kartik\mpdf\Pdf;
use yii\helpers\Url;
use Yii;
use app\models\Recipes;
use app\models\RecipesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Patient;
use yii\filters\AccessControl;

/**
 * RecipesController implements the CRUD actions for Recipes model.
 */
class RecipesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'filtered-index', 'view', 'create', 'update', 'find-model'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'filtered-index', 'view', 'create', 'update', 'find-model'],
                        'roles' => ['doctor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Recipes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecipesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Recipes models.
     * @return mixed
     */
    public function actionPrint()
    {
        $recipe = Recipes::find()->where(['id' => 1])->one();

        return $this->render('print', [
            'recipe' => $recipe,
        ]);
    }

    // Privacy statement output demo
    public function actionPrinting($recipe_id) {
        $recipe = Recipes::find()->where(['id' => $recipe_id])->one();

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_LETTER,
            'cssFile' => '../web/css/print_style.css',
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('print', ['recipe' => $recipe]),
            'options' => [
                // any mpdf options you wish to set
            ],
            'methods' => [
                'SetTitle' => 'Receptas',
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['Danės klinika||Sukurta: ' . date("Y-m-d H:i")],
                //'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => 'Kartik Visweswaran',
                'SetCreator' => 'Kartik Visweswaran',
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);
        return $pdf->render();
    }

    /**
     * Lists all TreatmentPlans models.
     * @return mixed
     */
    public function actionFilteredIndex($id_Patient)
    {
        $model = Patient::find()->where(['id_Patient' => $id_Patient])->one();
        $searchModel = new RecipesSearch();
        $dataProvider = $searchModel->searchFiltered(Yii::$app->request->queryParams, $id_Patient);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_Patient' => $id_Patient,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Recipes model.
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
     * Creates a new Recipes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_Patient)
    {
        //$patient = Patient::find()->where(['id_Patient' => $id_Patient])->one();

        /*$patients_list = [];
        foreach ($patients as $patient) {
            $patients_list[$patient->id_Patient] = $patient->name ." " . $patient->surname;
        }*/
        $model = new Recipes();

        $model->fk_patient = $id_Patient;
        $model->fk_user = \Yii::$app->user->id;
        if (!isset($model->expire)){
                $model->expire = date('Y-m-d', strtotime('+1 month'));
            }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_Patient' => $model->fk_patient]);
        }

        return $this->render('create', [
            'model' => $model,
            'id_Patient' => $id_Patient,
        ]);
    }

    /**
     * Updates an existing Recipes model.
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
     * Deletes an existing Recipes model.
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
     * Finds the Recipes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipes::findOne($id)) !== null) {
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
