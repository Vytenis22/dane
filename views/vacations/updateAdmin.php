<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Vacations */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), ['index'], ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Update Vacations: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vacations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vacations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formAdmin', [
        'model' => $model,
        'doctors_list' => $doctors_list,
        'status_list' => $status_list,
    ]) ?>

</div>
