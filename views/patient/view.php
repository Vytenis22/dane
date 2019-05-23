<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */
?>
<?php
    $navWidget = Nav::widget([
    'items' => [
        [
            'label' => 'Papildomai',
            'items' => [
                 ['label' => Yii::t('app', 'Treatment Plans'), 'url' => Url::to(['/treatment-plans/filtered-index', 
                    'id_Patient' => $model->id_Patient])],
                 '<li class="divider"></li>',
                 ['label' => Yii::t('app', 'Recipes'), 'url' => Url::to(['/recipes/filtered-index', 
                    'id_Patient' => $model->id_Patient])],
            ],
        ],
    ],
    'options' => ['class' =>'nav navbar-nav pull-right'],
]);
?>
<div class="row">
    <div class="col-sm-7">
            <p style="display: inline-block;">
                <?= Html::a(Yii::t('app', 'Return'), ['patient/index'], ['class' => 'btn btn-primary']) ?>
            </p>

                <div class="assignments">
                    <?= /*Html::a(Yii::t('app', 'Service Assignments'), Url::to(['service-assignment/index']), ['class' => 'btn btn-primary']);*/
                        \Yii::$app->user->can('manageVisits') ? $navWidget : "";
                    ?>
                </div>
    </div>
</div>



<?php
$this->title = $model->name . " " . $model->surname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<!-- Html::a(Yii::t('app', 'Treatment Plans'), Url::to(['treatment-plans/filtered-index', 'id_Patient' => $model->id_Patient]), ['class' => 'btn btn-primary pull-right'])  -->

<div class="patient-view">

    <h2><?= Html::encode($this->title) . " " . Html::encode(Yii::t('app', ' patient card'))?></h2>

    <div class="row">
            <div class="col-sm-7">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'card_number',
                        'options' => [
                            'class' => 'col-md-1',
                        ]
                    ],
                    'name',
                    'surname',
                    'birth_date',
                    [
                        'attribute' => 'code',
                        'options' => [
                            'class' => 'col-sm-1',
                        ],
                        'visible' => \Yii::$app->user->can('manageVisits'),
                    ],
                    'sex',
                    //'code',
                    'email:email',
                    'phone',
                    'address',
                    [
                        'label' => 'Miestas',
                        'attribute' => 'cityName',
                    ],

                    //'id_Patient',
                ],
            ]) ?>

        </div>
    </div>
    <?php if (\Yii::$app->user->can('manageVisits')) { ?>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_Patient], ['class' => 'btn btn-primary pull-rigth']); ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_Patient], [
            'class' => 'btn btn-danger pull-rigth',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                'ok' => Yii::t('app', 'OK'),
                'cancel' => Yii::t('yii', 'Cancel'),
            ],
        ]); } ?>
    </p>

</div>
