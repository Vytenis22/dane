<?php

namespace app\controllers;

use Yii;
use app\models\Assists;
use app\models\AssistsSearch;
use dektrium\user\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssistsController implements the CRUD actions for Assists model.
 */
class AssistsController extends Controller
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
     * Lists all Assists models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssistsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assists model.
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

        $model = new Assists();

        $model->start_time = date('Y-m-d H:i', strtotime($date));

        if ($model->load(Yii::$app->request->post())) {  
            $model->fk_user = $id;
            if ($model->save())                
            {
                //return $this->redirect(['view', 'id' => $model->id_visit]);
                return $this->redirect(['visit/timetable']);              
            }

        }

        return $this->renderAjax('assist', [
            'model' => $model,
            'doctors_list' => $doctors_list,
        ]);
    }

    /**
     * Creates a new Assists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Assists();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_assist]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Assists model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['visit/timetable']);
        }

        return \Yii::$app->user->can('createAssist') ? $this->render('update', [
            'model' => $model,
        ]) : $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Assists model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['visit/timetable']);
    }

    /**
     * Finds the Assists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assists the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Assists::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
