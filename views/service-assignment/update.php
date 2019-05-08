<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceAssignment */
?>

<?= Html::a(Yii::t('app', 'Return'), ['service-assignment/index'], ['class' => 'btn btn-primary']) ?>

<?php

$this->title = Yii::t('app', 'Update Service Assignment: {name}', [
    'name' => $model->profile->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->profile->name, 'url' => ['view', 'user_id' => $model->user_id, 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="service-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories_list' => $categories_list,
        'users_profiles_list' => $users_profiles_list,
    ]) ?>

</div>
