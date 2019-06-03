<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

	
$this->title = Yii::t('app', 'Reservation');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h3><?= Html::encode($this->title) ?></h3>
    <p>
        <h3>Jūs nesate susikūręs paciento kortelės.</h3>
    </p>

    <?= Html::a(Yii::t('app', 'Create Patient Card'), ['/patient/create-patient', 'id' => \Yii::$app->user->id], ['class' => 'btn btn-primary']) ?>
</div>
