<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceCategory */
?>
<div class="return-button">
<?= Html::a(Yii::t('app', 'Return'), Url::to(['/service-category/index']), ['class' => 'btn btn-primary']) ?>
</div>
<?php

$this->title = Yii::t('app', 'Create Service Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => Url::to(['/services/index'])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
