<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Patvirtinti';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-confirm">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('registrationConfirmed')): ?>

        <div class="alert alert-success">
            Registracija sėkmingai patvirtinta.
        </div>
            <?php elseif (Yii::$app->session->hasFlash('visitNotFound')): ?>
    
            <div class="alert alert-info">
                Vizitas nerastas.
            </div>
            <?php else: ?>
    
            <div>
                <p>
                    Nuorodos galiojimo laikas pasibaigęs.
                </p>
            </div>

    <?php endif; ?>	
	
	<?php	
	
	/**
	Modal::begin([
            'header'=>'<h4>Atšaukti</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
			'toggleButton' => ['label' => 'click me'],
        ]);
        
        echo "<div id='modalContent'></div>";
        Modal::end();
		*/
	
	?>

    <code><?= __FILE__ ?></code>
</div>
