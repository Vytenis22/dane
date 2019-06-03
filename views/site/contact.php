<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

	
$this->title = Yii::t('yii', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1 align="center"><?= Html::encode(Yii::t('yii', $this->title)) ?></h1>
    <div class="kont text">
        <div class="csinfo">
            <h2>Odontologijos klinika Klaipėdoje</h2>
            <p>
                <b>El. paštas: </b>
                <?= Html::mailto('info@danesodontologijosklinika.lt', 'info@danesodontologijosklinika.lt') ?>
            </p>
            <p>
                <b>Telefonas: </b>
                <?= Html::mailto('+370 657 88 701', '+370 657 88 701') ?>
            </p>
            <p>
                <b>Adresas: </b>
                Danės g. 21, Klaipėda  
            </p>
            <h3>Darbo laikas</h3>
            <p>Pirmadienis - Penktadienis: 8:00 - 18:00</p>
        </div>
        <div id="map" style="position: relative; overflow: hidden;">

            <iframe width='100%' height='100%' id='mapcanvas' src='https://maps.google.com/maps?q=Dan%C4%97s%20g.%2021,%20Klaip%C4%97da&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=&amp;output=embed' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'><div class="zxos8_gm"><a rel="nofollow"  href="https://freecarcheck.co.uk">https://freecarcheck.co.uk</a></div><div style='overflow:hidden;'><div id='gmap_canvas' style='height:100%;width:100%;'></div></div><div><small>Powered by <a href="https://www.embedgooglemap.co.uk">Embed Google Map</a></small></div></iframe>

        </div>
        <div class="cl" style="margin-bottom:40px"></div>
        <div class="csinfo">
            <h2>Rekvizitai</h2>
            <p>
                <strong>UAB Sveikatos Gija</strong>
            </p>
            <p>
                <strong>Įmonės kodas:</strong>
                 301206554
            </p>
            <p>
                <strong>El. paštas:</strong>
                  info@danesodontologijosklinika.lt
            </p>
            <p>
                <strong>Telefono numeris:</strong>
                   +370 657 88701
            </p>
        </div>
        <!-- <div class="suzk">
            <h2>Parašykite mums</h2>
        </div> -->
    </div>
    
</div>
