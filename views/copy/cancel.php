<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Atšaukti';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-cancel">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('visitCanceled')): ?>

        <div class="alert alert-success">
            Visit canceled.
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
