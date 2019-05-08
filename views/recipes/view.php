<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Recipes */
?>
    <!-- <div class="return-button">
        <?= Html::a(Yii::t('app', 'Return'), ['filtered-index', 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary']) ?>
    </div> -->
    <ul class="surround">
        <li>
            <?= Html::a(Yii::t('app', 'Return'), ['filtered-index', 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary']) ?>
        </li>
        <li>
            <?= Html::a(Yii::t('app', 'Print'), ['printing', 'recipe_id' => $model->id], [
                'class'=>'btn btn-primary', 
                'target'=>'_blank',
            ]); ?>
        </li>
    </ul>
<?php

$this->title = $model->patientFullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Patients'), 'url' => ['patient/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '{name}', ['name' => $model->patientFullName]), 'url' => Url::to(['patient/view', 'id' => $id_Patient])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recipes'), 'url' => Url::to(['filtered-index', 
    'id_Patient' => $id_Patient])];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="recipes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-6">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',

                    //'create_at',
                    [
                        'attribute' => 'create_at',
                        //'format' => ['date', 'Y-MM-dd HH:mm'],     
                        'format' => ['date', 'php: Y M d, H:i']        
                    ],

                    'expire',
                    'rp',
                    'N',
                    'S',
                    //'fk_patient',
                    //'fk_user',
                    [
                        'label' => 'Gydytojas',
                        'attribute' => 'user.profile.name',               
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'id_Patient' => $id_Patient], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'id_Patient' => $id_Patient], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
