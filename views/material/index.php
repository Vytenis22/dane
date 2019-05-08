<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

?>
<div class="row">
    <div class="col-sm-8">

                <div class="assignments">
                    <?= Html::a(Yii::t('app', 'Material Types'), Url::to(['material-type/index']), ['class' => 'btn btn-primary']) ?>
                </div>
    </div>
</div>



<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\MaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-index">
    
    <?php
    
        Modal::begin([
            //'header'=>'<h4>Visit</h4>',
            //'toggleButton' => ['label' => 'click me', 'class' => 'btn btn-primary'],
            'size' => '',
            'id'=>'modal', 

        ]);
        
        echo "<div id='modalContent'></div>";
        Modal::end();
        
    ?>

    <div class="row">
        <div class="col-sm-8">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="buttons">
            <!-- <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Create Material'), ['create'], ['class' => 'btn btn-success']) ?>
            </p> -->

            <?= Html::button(yii::t('app', 'Create Material'), ['value' => Url::to(['material/create-ajax']), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>

            <!-- <div class="assignments">
                <?= Html::a(Yii::t('app', 'Material Types'), Url::to(['material-type/index']), ['class' => 'btn btn-primary']) ?>
            </div> -->
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id_material',
                'name',
                //'price',
                [
                    'attribute' => 'price',
                    'label' => Yii::t('app', 'Price'),
                    'options' => [
                            'class' => 'col-sm-1',
                        ],       
                ],
                'info',
    			[
    				'label' => 'Tipas',
    				'attribute' => 'mat',
    				'value' => 'mat.name',
    			],
                //'fk_id_material_type',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
