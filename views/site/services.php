<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Services');
$this->params['breadcrumbs'][] = Yii::t('yii', $this->title);
?>
<div class="site-about">
    <h1 align="center"><?= Html::encode(Yii::t('yii', $this->title)) ?></h1>
    <ul class="pasllist">
        <li>
            <div class="pasinfo">
                <?= 
                    Html::a('Dantų implantacija', ['site/index'], ['class' => 'pname']);
                ?>
                <span class='papr'>
                    Dantų implantai - tai vienas didžiausių šiuolaikinės odontologijos laimėjimų. Dantų implantai išsaugo turimus paciento dantis, atkuria trūkstamus, sustabdo žandikaulio nykimą, sugrąžina normalias kramtymo, sąkandžio funkcijas, pasitikėjimą savimi ir nuostabią šypseną. Danties implantas yra titaninis sraigtas, kuris įsodinamas į žandikaulio kaulą vietoje trūkstamo danties. Taip sukuriama atrama danties atstatymui vainikėliu. Yra daug būdų atstatyti danties vainiką, tačiau tik implantavimas gali pilnai atstatyti dantį - tiek šaknį, tiek vainiką (...
                </span>
                <?= 
                    Html::a('Skaityti plačiau ›', ['site/index'], ['class' => 'skpp']);
                ?>
            </div>
            <?= 
                Html::a(Html::img(Url::to('@web/images/m_837605c6ba.jpg'), ['alt' => 'Dantų implantacija']), ['site/index'], ['class' => 'pfoto']);
            ?>
            <div class="cl"></div>
        </li>
        <li>
            <div class="pasinfo">
                <?= 
                    Html::a('Burnos chirurgija', ['site/index'], ['class' => 'pname']);
                ?>
                <span class='papr'>
                    Burnos chirurgija - plati odontologijos sritis, apimanti ne tik dantų, bet ir liežuvio, burnos gleivinės, seilių liaukų, žandikaulių, sinusų patologijų ar navikų diagnostiką ir chirurginį gydymą. Burnos chirurgija yra neatsiejama kompleksinio gydymo dalis, implantuojant ir protezuojant dantis, taikant ortodontinį gydymą. Klinikoje teikiamos burnos chirurgijos paslaugos: ...
                </span>
                <?= 
                    Html::a('Skaityti plačiau ›', ['site/index'], ['class' => 'skpp']);
                ?>
            </div>
            <?= 
                Html::a(Html::img(Url::to('@web/images/m_597b3d7d7c.jpg'), ['alt' => 'Dantų implantacija']), ['site/index'], ['class' => 'pfoto']);
            ?>
            <div class="cl"></div>
        </li>
        <li>
            <div class="pasinfo">
                <?= 
                    Html::a('Dantų protezavimas', ['site/index'], ['class' => 'pname']);
                ?>
                <span class='papr'>
                    Dantų protezavimasNe visiems pavyksta išsaugoti savus dantis. Dėl įvairių patirtų traumų, ligų, smarkių pažeidimų, nusidėvėjimo ir kitų dalykų kartais atkurti danties plombinėmis medžiagomis neįmanoma. Dantų netekimas dažnai sukelia fizinių (tokių, kaip kramtymo, virškinimo sistemos sutrikimus, įvairius tarties sutrikimus), ir psichologinių (nepasitikėjimo savimi) problemų. Todėl protezavimo pasirinkimas - viena iš galimybių toliau džiaugtis pilnaverčiu gyvenimu. Dantų protezavimui naudojamos restauracijos yra tvirtos, patogios ir ilgaamžės. Mūsų klinikoje dant...
                </span>
                <?= 
                    Html::a('Skaityti plačiau ›', ['site/index'], ['class' => 'skpp']);
                ?>
            </div>
            <?= 
                Html::a(Html::img(Url::to('@web/images/m_dantu-protezavimas-a554.jpg'), ['alt' => 'Dantų protezavimas']), ['site/index'], ['class' => 'pfoto']);
            ?>
            <div class="cl"></div>
        </li>
        <li>
            <div class="pasinfo">
                <?= 
                    Html::a('Dantų gydymas', ['site/index'], ['class' => 'pname']);
                ?>
                <span class='papr'>
                    Jūsų dantis gali pažeisti kariesas, traumos, nekarioziniai dantų pažeidimai: fluorozė, hipoplazija, pleištiniai defektai, dantų nusidėvėjimas (patologinis, fiziologinis), erozijos. Labiausiai paplitęs danties kietųjų audinių pažeidimas - kariesas. Laiku nepastebėjus ir nesugydžius mažos skylutės, jinai didėja, atsiranda jautrumas karščiui, šalčiui, saldžiam maistui. Delsiant kreiptis į odontologą, gali prasidėti danties nervo ar audinių, esančių apie dantį, uždegimas. Tuomet tenka dantį ne tik plombuoti, bet ir gydyti šaknies kanalus, o gal v...
                </span>
                <?= 
                    Html::a('Skaityti plačiau ›', ['site/index'], ['class' => 'skpp']);
                ?>
            </div>
            <?= 
                Html::a(Html::img(Url::to('@web/images/m_95bf0dcbe9.jpg'), ['alt' => 'Dantų gydymas']), ['site/index'], ['class' => 'pfoto']);
            ?>
            <div class="cl"></div>
        </li>
    </ul>
</div>
