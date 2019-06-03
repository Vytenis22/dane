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

$this->title = Yii::t('app', 'Create Vacations');
$this->params['breadcrumbs'][] = \Yii::$app->user->can('confirmVacations') ? ['label' => Yii::t('app', 'Vacations'), 'url' => ['index']] : ['label' => Yii::t('app', 'Vacations'), 'url' => ['my-vacations']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formAdmin', [
        'model' => $model,
        'doctors_list' => $doctors_list,
    ]) ?>

</div>
