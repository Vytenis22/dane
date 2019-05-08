<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Atšaukti vizito laiką';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-requestcancel">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the Cancel page. You may modify the following file to customize its content:
    </p>
	
	<div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'requestcancel-form']); ?>

                    <?= $form->field($model, 'email') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <code><?= __FILE__ ?></code>
</div>
