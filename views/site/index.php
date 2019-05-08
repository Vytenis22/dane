<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

	
	<!--//Html::img('@web/images/odontologijos-klinika-547e.jpg', ['alt'=>'Odontologijos klinika']);
	
	<img src="/images/odontologijos-klinika-547e.jpg" alt="Odontologijos klinika"> -->
	
	<!-- <p>
		 Html::a('Registruotis', ['site/reservation'], ['class' => 'btn btn-primary']) 
	</p> -->
    <div id="slider">
        <ul>
            <li>
                <div>
                    <span class="small">Gražūs dantys.</span>
                    <span>Graži šypsena!</span>
                </div>                
            </li>
        </ul>
    </div>
    <div id="trys">
        <div class="cnt">
            <div>
                <?= Html::a(Html::img(Url::to('@web/images/paslaugos.png'), ['alt' => 'Danės klinika']), Url::to(['/site/services']), ['class' => 'ssim']); ?>
                <?= Html::a(Yii::t('app', 'Services'), Url::to(['/site/services']), ['class' => 'ssname']); ?>
                Burnos chirurgija, dantų implantacija ir protezavimas, dantų gydymas...
                <?= Html::a(Yii::t('app', 'Skaitykite plačiau'), Url::to(['/site/services']), ['class' => 'skp']); ?>
            </div>
            <div>
                <?= Html::a(Html::img(Url::to('@web/images/naujienos.png'), ['alt' => 'Danės klinika']), Url::to(['/site/services']), ['class' => 'ssim']); ?>
                <?= Html::a(Yii::t('yii', 'Prices'), Url::to(['/site/prices']), ['class' => 'ssname']); ?>
                Šioje skiltyje pateikiamos mūsų klinikoje suteikiamų paslaugų kainos.
                <?= Html::a(Yii::t('app', 'Skaitykite plačiau'), Url::to(['/site/prices']), ['class' => 'skp']); ?>
            </div>
            <div>
                <?= Html::a(Html::img(Url::to('@web/images/personalas-new.png'), ['alt' => 'Danės klinika']), Url::to(['/site/services']), ['class' => 'ssim']); ?>
                <?= Html::a(Yii::t('app', 'Personnel'), Url::to(['/site/personnel']), ['class' => 'ssname']); ?>
                Pas mus dirba tik aukštos kvalifikacijos specialistai.
                <?= Html::a(Yii::t('app', 'Skaitykite plačiau'), Url::to(['/site/personnel']), ['class' => 'skp']); ?>
            </div>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-sm-4">
                <!-- <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p> -->
            </div>
            <div class="col-sm-4">
                <!-- <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p> -->
            </div>
            <div class="col-sm-4">
                <!-- <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p> -->
            </div>
        </div>

    </div>
</div>
