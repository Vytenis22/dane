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
            <div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                <div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;">
                    
                </div>
            </div>
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
        <div class="suzk">
            <h2>Parašykite mums</h2>
        </div>
    </div>
    
</div>
