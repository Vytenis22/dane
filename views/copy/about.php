<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'About';
$this->params['breadcrumbs'][] = Yii::t('yii', $this->title);
?>
<div class="site-about">
    <h1><?= Html::encode(Yii::t('yii', $this->title)) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>
	
	<?php
	Modal::begin([
            'header'=>'<h4>Visit</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
        ]);
        
        echo "<div id='modalContent'></div>";
        Modal::end();
	
	?>

    <code><?= __FILE__ ?></code>
</div>
