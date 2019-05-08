<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

	
	<!--//Html::img('@web/images/odontologijos-klinika-547e.jpg', ['alt'=>'Odontologijos klinika']);
	
	<img src="/images/odontologijos-klinika-547e.jpg" alt="Odontologijos klinika"> -->
	
	<p>
		<?= Html::a('Registruotis', ['site/reservation'], ['class' => 'btn btn-primary']) ?>
	</p>
	

    <div class="jumbotron">
		<div id="smile">
        <h1>Graži šypsena!</h1>
		</div>
		
		<p>
			<!-- <a class="btn btn-lg btn-danger" href="site/request">Atšaukti registraciją</a> -->
            <?= Html::a('Atšaukti registraciją', ['site/request'], ['class' => 'btn btn-danger']) ?>
		</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
