<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceAssignment */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['/service-assignment/index']), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Create Service Assignment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => Url::to(['/services/index'])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories_list' => $categories_list,
        'users_profiles_list' => $users_profiles_list,
    ]) ?>

</div>
