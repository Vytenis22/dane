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
                    <h2>Nuorodos galiojimo laikas pasibaigęs.</h2>
                </p>
                <p>
                    <h4>Registruokitės vizitui iš naujo.</h4>
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
</div>
