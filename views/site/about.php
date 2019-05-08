<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'About';
$this->params['breadcrumbs'][] = Yii::t('yii', $this->title);
?>
<div class="site-about">
    <div class="text">
        <h1><?= Html::encode(Yii::t('yii', $this->title)) ?></h1>
        <p style="text-align: justify;">
            <?=
                Html::img(Url::to('@web/images/klinika.jpg'), ['alt' => 'Danės klinika', 'style' => 'margin: 5px 0 30px 30px; float:right;']);
            ?>
            Kartais sunku nuspręsti, kam patikėti savo dantų profesionalią priežiūrą ir gydymą.
            <br>
            <em>DANĖS ODONTOLOGIJOS KLINIKA</em>
             - tai lengvas kelias į Jūsų gražią ir sveiką šypseną!
        </p>
        <p style="text-align: justify;">
            <em>ODONTOLOGINĖS PASLAUGOS</em>
              vienoje vietoje!
        </p>
        <p style="text-align: justify;">
            Teikiame aukščiausios kokybės odontologijos paslaugas, tokias kaip burnos higieną, dantų balinimą, estetinį plombavimą, dantų implantaciją, protezavimą, burnos chirurgiją, terapinį dantų gydymą ir kitas paslaugas, tinkančias visiems Jūsų šeimos nariams. Komandinis darbas - tai stiprioji mūsų klinikos pusė.
        </p>
        <p style="text-align: justify;">
            PROFESIONALUS klinikos kolektyvas - tai gydytojų odontologų ir specialistų komanda (burnos chirurgas, gydytojai terapeutai, gydytojas endodentologas, burnos higienistas). Esame reiklūs sau ir žengiame koja kojon su odontologijos mokslo pažanga - giliname savo žinias tiek Lietuvos, tiek užsienio mokslinėse konferencijose, praktiniuose bei teoriniuose seminaruose.
        </p>
        <p style="text-align: justify;">
            MODERNIAUSIA ODONTOLOGINĖ ĮRANGA ir SERTIFIKUOTOS PRIEMONĖS. Klinikoje įdiegta naujausia skaitmeninė rentgeno diagnostikos aparatūra, darbui naudojama moderniausia kompiuterizuota odontologinė įranga. Gydytojai dirba tik su aparatūra ir medžiagomis, atitinkančiomis tarptautinius standartus, taip siekdami užtikrinti aukščiausią paslaugų kokybę. Mes džiaugiamės, galėdami Jums pasiūlyti dantų gydymą, atitinkantį aukščiausius medicinos standartus.
        </p>
        <p>
            <br>            
            Jūsų Danės odontologijos klinikos kolektyvas
        </p>
        <p>
            <em>Lengvas kelias į šypseną!</em>
        </p>
        <p>
            
        </p>
        <p>
            <strong>Klinikos darbo laikas:</strong>
        </p>
        <p>
            Pirmadieniais – penktadieniais 8
            <sup>00</sup>
            - 18
            <sup>00</sup>
            val.
        </p>
        <p>
            Telefonas pasiteirauti (Klaipėda): Tel. +370 657 88701
        </p>
    </div>
</div>
