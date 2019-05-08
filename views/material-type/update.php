<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\MaterialType */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['/material-type/index']), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Update Material Type: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Materials'), 'url' => Url::to(['/material/index'])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Material Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_material_type]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="material-type-update">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

</div>
