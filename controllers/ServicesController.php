<?php

namespace app\controllers;

use Yii;
use app\models\Services;
use app\models\ServiceCategory;
use app\models\ServiceDuration;
use app\models\ServicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use dektrium\user\models\User;
use yii\filters\AccessControl;

/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [            
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'findModel'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'findModel'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
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
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $duration_model = new ServiceDuration();
        $categories = ServiceCategory::find()->all();
        $categories_list = ArrayHelper::map($categories, 'id', 'parent_name');
        $model = new Services();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $duration_model->service_id = $model->id;
            if ($duration_model->load(Yii::$app->request->post()) && $duration_model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }

        return $this->render('create', [
            'model' => $model,
            'duration_model' => $duration_model,
            'categories_list' => $categories_list,
        ]);
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $duration_model = ServiceDuration::find()->where(['service_id' => $id])->one();
        $categories = ServiceCategory::find()->all();
        $categories_list = ArrayHelper::map($categories, 'id', 'parent_name');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($duration_model->load(Yii::$app->request->post()) && $duration_model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            } 
        }

        return $this->render('update', [
            'model' => $model,
            'duration_model' => $duration_model,
            'categories_list' => $categories_list,
        ]);
    }

    /**
     * Deletes an existing Services model.
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
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne($id)) !== null) {
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
