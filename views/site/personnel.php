<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Personnel');
?>
<div class="site-personnel">
    <div class="left-list">
        <ul class="personnel-tabs">
            <li id="tab1" class="on">
                <span>Gydytojai</span>
            </li>
            <li id="tab2">
                <span>Burnos higienistai</span>
            </li>
            <li id="tab3">
                <span>Odontologo padėjėjai</span>
            </li>
            <li id="tab4">
                <span>Administratoriai</span>
            </li>
        </ul>
    </div>

    <div class="right-list">

    <div class="title">
        <h2>
            <?= Html::encode($this->title) ?>
        </h2>
    </div>
        <ul id="stab1" class="personnel" style="display: block;">
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/alvydas_vaiciunas.jpg'), ['alt' => 'Alvydas Vaičiūnas']), ['site/index']);
                ?>
                <?= 
                    Html::a('Alvydas Vaičiūnas', ['site/index'], ['class' => 'name_surname']);
                ?>   
                <?= Html::tag('span', 'Gydytojas odontologas, burnos chirurgas. Licencijos Nr. OPL- 02005; Nr. OPL-04004', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?>            
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/mindaugas_vaiciunas.jpg'), ['alt' => 'Mindaugas Vaičiūnas']), ['site/index']);
                ?>
                <?= 
                    Html::a('Mindaugas Vaičiūnas', ['site/index'], ['class' => 'name_surname']);
                ?>   
                <?= Html::tag('span', 'Gydytojas odontologas, burnos chirurgas. Licencijos Nr. OPL- 02005; Nr. OPL-04004', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?>  
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/giedre_stonkuviene.jpg'), ['alt' => 'Giedrė Stonkuvienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Giedrė Stonkuvienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė, endodontologė. Licencijos Nr. OPL-04054; Nr. OPL-04779', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/rasa_tarute.jpg'), ['alt' => 'Rasa Tarutė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Rasa Tarutė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-01966', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/justina_vaiciuniene.jpg'), ['alt' => 'Justina Vaičiūnienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Justina Vaičiūnienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-04762', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/ruta_nemuniene.jpg'), ['alt' => 'Rūta Nemunienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Rūta Nemunienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-03513', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/irma_lubiene.jpg'), ['alt' => 'Irma Lubienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Irma Lubienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-02630', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/simona_simutiene.jpg'), ['alt' => 'Simona Simutienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Simona Simutienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-04508', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/sonata_kalvaityte.jpg'), ['alt' => 'Sonata Kalvaitytė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Sonata Kalvaitytė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-05025', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/ieva_kukauskaite.jpg'), ['alt' => 'Ieva Kukauskaitė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Ieva Kukauskaitė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-05026', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/gabriele_bauziene.jpg'), ['alt' => 'Gabrielė Baužienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Gabrielė Baužienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytoja odontologė. Licencijos Nr. OPL-05128', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
        </ul>
        <ul id="stab2" class="personnel" style="display: none;">            
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/lina_maciukeviciene.jpg'), ['alt' => 'Lina Maciukevičienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Lina Maciukevičienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Burnos higienistė. Licencijos Nr. BPL-06734', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/guoda_rimkute.jpg'), ['alt' => 'Guoda Rimkutė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Guoda Rimkutė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Burnos higienistė. Licencijos Nr. BPL-07155', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/nonita_remeikyte.jpg'), ['alt' => 'Nonita Remeikytė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Nonita Remeikytė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Burnos higienistė. Licencijos Nr. BPL-06888', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
        </ul>
        <ul id="stab3" class="personnel" style="display: none;">
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/edita_uleviciene.jpg'), ['alt' => 'Edita Ulevičienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Edita Ulevičienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytojo odontologo padėjėja. Licencijos Nr. BPL-02974', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/vilija_arlauskaite.jpg'), ['alt' => 'Vilija Arlauskaitė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Vilija Arlauskaitė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytojo odontologo padėjėja. Licencijos Nr. BPL-06957', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/rimante_komskyte.jpg'), ['alt' => 'Rimantė Komskytė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Rimantė Komskytė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytojo odontologo padėjėja. Licencijos Nr. BPL-06841', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/dovile_staneliene.jpg'), ['alt' => 'Dovilė Stanelienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Dovilė Stanelienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Odontologo pagalbininkė', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/kristina_novikova.jpg'), ['alt' => 'Kristina Novikova']), ['site/index']);
                ?>
                <?= 
                    Html::a('Kristina Novikova', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Odontologo pagalbininkė', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/nera-foto.png'), ['alt' => 'Sandra Žalgirienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Sandra Žalgirienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Gydytojo odontologo padėjėja. Licencijos Nr. BPL-05765', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
        </ul>
        <ul id="stab4" class="personnel" style="display: none;">
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/lijana_steponaitiene.jpg'), ['alt' => 'Lijana Steponaitienė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Lijana Steponaitienė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Administratorė', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
            <li>
                <?= 
                Html::a(Html::img(Url::to('@web/images/personnel/ieva_jozune.jpg'), ['alt' => 'Ieva Jozūnė']), ['site/index']);
                ?>
                <?= 
                    Html::a('Ieva Jozūnė', ['site/index'], ['class' => 'name_surname']);
                ?>  
                <?= Html::tag('span', 'Administratorė', ['class' => 'gapr']) ?>
                <?= 
                    Html::a('Skaityti plačiau', ['site/index'], ['class' => 'skpp']);
                ?> 
            </li>
        </ul>
    </div>
</div>
