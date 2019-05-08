<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['/services/index']), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Service Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => Url::to(['/services/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-category-index">
    <div class="row">
        <div class="col-sm-4">

        <h1 style="margin-top: 10px"><?= Html::encode($this->title) ?></h1>
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create Service Category'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'parent_name',
                [
                    'label' => 'Pavadinimas',
                    'attribute' => 'parent_name',
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>

        </div>
    </div>
</div>
