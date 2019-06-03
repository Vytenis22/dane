<?php

namespace app\controllers;

use Yii;
use app\models\Services;
use app\models\ServiceAssignment;
use app\models\ServiceAssignmentSearch;
use app\models\ServiceCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use yii\filters\AccessControl;

/**
 * ServiceAssignmentController implements the CRUD actions for ServiceAssignment model.
 */
class ServiceAssignmentController extends Controller
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
     * Lists all ServiceAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ServiceAssignment model.
     * @param integer $user_id
     * @param integer $category_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($user_id, $category_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $category_id),
        ]);
    }

    /**
     * Creates a new ServiceAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $users = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->where(['=', 'auth_assignment.item_name', 'doctor'])
            ->orderBy(['user.id' => SORT_ASC])
            ->all();
        //$users = User::find()->where(['role' => 10])->all();
        /*$users = Profile::find()
        ->leftJoin('user', 'user.id = user_id')
        ->where(['user.role' => 10])->all();*/
        $users_profiles = array();
        foreach ($users as $user) {
            $users_profiles[] = $user->profile;
        }
        $users_profiles_list = ArrayHelper::map($users_profiles, 'user_id', 'name');
        $categories = ServiceCategory::find()->all();
        $categories_list = ArrayHelper::map($categories, 'id', 'parent_name');
        $model = new ServiceAssignment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'user_id' => $model->user_id, 'category_id' => $model->category_id]);
            Yii::$app->session->setFlash('assignmentCreated');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'categories_list' => $categories_list,
            'users_profiles_list' => $users_profiles_list,
        ]);
    }

    /**
     * Updates an existing ServiceAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $category_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($user_id, $category_id)
    {
        $users = User::find()->where(['role' => 10])->all();
        $users_profiles = array();
        foreach ($users as $user) {
            $users_profiles[] = $user->profile;
        }
        $users_profiles_list = ArrayHelper::map($users_profiles, 'user_id', 'name');
        $categories = ServiceCategory::find()->all();
        $categories_list = ArrayHelper::map($categories, 'id', 'parent_name');
        $model = $this->findModel($user_id, $category_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'category_id' => $model->category_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories_list' => $categories_list,
            'users_profiles_list' => $users_profiles_list,
        ]);
    }
    
    /**
     * Gives back filtered service assignments array on chosen doctor.
     * @return 
     */
    public function actionServices($id) 
    {           
        $assigned_services = ServiceAssignment::find()
        ->where(['user_id' => $id])->all();

        $service_categories = ServiceCategory::find()->all();

        if(count($assigned_services) > 0)
        {
            $assigned_services_id = array();
            foreach ($assigned_services as $service) {
                $assigned_services_id[] = $service->category_id;
            }

            $filtered_categories = array();

            foreach ($service_categories as $category) {
                if (!in_array($category->id, $assigned_services_id))
                {
                    $filtered_categories[] =  $category;
                }
            }

            //$assigned_services_list = ArrayHelper::getColumn($assigned_services, 'category_id');
            
            /*$filtered_docs = User::find()
            ->leftJoin('service_assignment', 'service_assignment.user_id = user.id')
            ->where(['service_assignment.category_id' => $service->parent_id])
            ->all();
            
            $filt_profiles = array();
            foreach ($filtered_docs as $doc) 
            {
                $filt_profiles[] = $doc->profile;
            }*/
            
            echo "<option value='' disabled selected hidden>Pasirinkite gydytoją…</option>";
            //echo count($doctor) . "\n";
            
            if(count($filtered_categories)>0){
                foreach($filtered_categories as $category){
                    echo "<option value='$category->id'>$category->parent_name</option>";
                }
            }
            else{
                echo "<option>Sąrašas tuščias</option>";
            }
        } else {
            echo "<option value='' disabled selected hidden>Pasirinkite kategoriją…</option>";

            if(count($service_categories)>0){
                foreach($service_categories as $category){
                    echo "<option value='$category->id'>$category->parent_name</option>";
                }
            }
            else{
                echo "<option>Sąrašas tuščias</option>";
            }
        }

        
    }

    /**
     * Deletes an existing ServiceAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $category_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($user_id, $category_id)
    {
        $this->findModel($user_id, $category_id)->delete();

        Yii::$app->session->setFlash('assignmentDeleted');
        return $this->redirect(['index']);
    }

    /**
     * Finds the ServiceAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $category_id
     * @return ServiceAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $category_id)
    {
        if (($model = ServiceAssignment::findOne(['user_id' => $user_id, 'category_id' => $category_id])) !== null) {
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
