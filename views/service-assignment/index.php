<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['/services/index']), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Service Assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => Url::to(['/services/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-assignment-index">
    <div class="row">
        <div class="col-sm-7">

        <h1 style="margin-top: 10px"><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('assignmentCreated')): ?>

            <div class="alert alert-success">
                Sėkmingai priskyrėte paslaugos kategoriją gydytojui.
            </div>

        <?php elseif (Yii::$app->session->hasFlash('assignmentDeleted')): ?>
    
            <div class="alert alert-info">
                Sėkmingai panaikinote paslaugų kategorijos priskyrimą gydytojui.
            </div>

        <?php endif; ?>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create Service Assignment'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'user_id',
                [
                    'label' => 'Gydytojas',
                    'attribute' => 'user',
                    'value' => 'user.profile.name',
                ],

                //'category_id',
                [
                    'label' => 'Kategorija',
                    'attribute' => 'category',
                    'value' => 'category.parent_name',
                ],
                'created_at',

                ['class' => 'yii\grid\ActionColumn',
                 'template' => '{delete}',
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>

        </div>
    </div>
</div>
