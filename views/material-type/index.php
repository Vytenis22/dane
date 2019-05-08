<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MaterialTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['/material/index']), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Material Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Materials'), 'url' => Url::to(['/material/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-type-index">
    <div class="row">
        <div class="col-sm-5">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create Material Type'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id_material_type',
                //'name',
                [
                    'attribute' => 'name',
                    'options' => [
                            'class' => 'col-sm-9',
                        ],       
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
