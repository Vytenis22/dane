<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

	
$this->title = Yii::t('app', 'Dental services prices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-personnel">

    <div class="left-list">
        <div class="lmen">
            <h2>Paslaugos</h2>
            <ul>
                <li rel="#ks1">                
                    <?= 
                        Html::a('Konsultacijos, tyrimai', ['site/index']);
                    ?> 
                </li>
                <li rel="#ks2">                
                    <?= 
                        Html::a('Rentgenologiniai tyrimai', ['site/index']);
                    ?>                    
                </li>
                <li rel="#ks3">                
                    <?= 
                        Html::a('Dantų implantacija', ['site/index']);
                    ?>                        
                </li>
                <li rel="#ks4">
                    <?= 
                        Html::a('Dantų implantacija STRAUMANN implantais', ['site/index']);
                    ?> 
                </li>
                <li rel="#ks5">
                    <?= 
                        Html::a('Chirurginis dantų gydymas', ['site/index']);
                    ?> 
                </li>
                <li rel="#ks6">
                    <?= 
                        Html::a('Terapinis dantų gydymas', ['site/index']);
                    ?> 
                </li>
                <li rel="#ks7">
                    <?= 
                        Html::a('Burnos higiena', ['site/index']);
                    ?> 
                </li>
                <li rel="#ks8">
                    <?= 
                        Html::a('Vaikų dantų gydymas', ['site/index']);
                    ?> 
                </li>
                <li rel="#ks9">
                    <?= 
                        Html::a('Dantų balinimas', ['site/index']);
                    ?> 
                </li>
                <li rel="#ks10">
                    <?= 
                        Html::a('Dantų protezavimas', ['site/index']);
                    ?> 
                </li>
            </ul>
        </div>
    </div>
    <div class="right-list">
        <div class="title">
            <h2>
                <?= Html::encode($this->title) ?>
            </h2>
        </div>
        <div class="text contact">
            <h2 id="ks1">Konsultacijos, tyrimai</h2>
            <table>
                <tbody>
                    <tr>
                        <td style="text-align: left;">
                        <strong>Paslauga</strong>
                        </td>
                        <td style="width: 120px; text-align: center;">
                            <strong>Kaina</strong>                        
                        </td>
                    </tr>
                    <tr>
                        <td> Profilaktinė apžiūra</td>
                        <td style="text-align: center;">10</td>
                    </tr>
                    <tr>
                        <td> Konsultacija</td>
                        <td style="text-align: center;">20</td>
                    </tr>
                    <tr>
                        <td> Gydymo plano sudarymas</td>
                        <td style="text-align: center;">30</td>
                    </tr>
                    <tr>
                        <td> Skubios pagalbos suteikimas (vaistų uždėjimas)</td>
                        <td style="text-align: center;">25</td>
                    </tr>
                    <tr>
                        <td> Nuskausminimas</td>
                        <td style="text-align: center;">10</td>
                    </tr>
                </tbody>
            </table>
            <h2 id="ks2">Rentgenologiniai tyrimai</h2>
            <table>
                <tbody>
                    <tr>
                        <td style="text-align: left;">
                        <strong>Paslauga</strong>
                        </td>
                        <td style="width: 120px; text-align: center;">
                            <strong>Kaina</strong>                        
                        </td>
                    </tr>
                    <tr>
                        <td>Dentalinė rentgeno nuotrauka</td>
                        <td style="text-align: center;">5 - 10</td>
                    </tr>
                    <tr>
                        <td>Ortopantomograma (panoraminė rentgeno nuotrauka)</td>
                        <td style="text-align: center;">20</td>
                    </tr>
                    <tr>
                        <td>3D rentgeno nuotrauka (vieno segmento)</td>
                        <td style="text-align: center;">30</td>
                    </tr>
                    <tr>
                        <td>3D rentgeno nuotrauka (viso žandikaulio)</td>
                        <td style="text-align: center;">45</td>
                    </tr>
                    <tr>
                        <td>3D rentgeno nuotrauka (visos galvos)</td>
                        <td style="text-align: center;">60</td>
                    </tr>
                </tbody>
            </table>
            <h2 id="ks7">Burnos higiena</h2>
            <table>
                <tbody>
                    <tr>
                        <td style="text-align: left;">
                        <strong>Paslauga</strong>
                        </td>
                        <td style="width: 120px; text-align: center;">
                            <strong>Kaina</strong>                        
                        </td>
                    </tr>
                    <tr>
                        <td>Higieninis dantų valymas</td>
                        <td style="text-align: center;">30 - 60</td>
                    </tr>
                    <tr>
                        <td>Pakartotinis higieninis dantų valymas</td>
                        <td style="text-align: center;">20 - 30</td>
                    </tr>
                </tbody>
            </table>
            <h2 id="ks9">Dantų balinimas</h2>
            <table>
                <tbody>
                    <tr>
                        <td style="text-align: left;">
                        <strong>Paslauga</strong>
                        </td>
                        <td style="width: 120px; text-align: center;">
                            <strong>Kaina</strong>                        
                        </td>
                    </tr>
                    <tr>
                        <td>Danties balinimas po endodontinio gydymo</td>
                        <td style="text-align: center;">30</td>
                    </tr>
                    <tr>
                        <td>Balinimo kapa (vieno žandikaulio)</td>
                        <td style="text-align: center;">50</td>
                    </tr>
                    <tr>
                        <td>Balinimo gelis (vienas švirkštas)</td>
                        <td style="text-align: center;">15</td>
                    </tr>
                    <tr>
                        <td>Balinimas lazeriu (1  -  6 dantų)</td>
                        <td style="text-align: center;">100</td>
                    </tr>
                    <tr>
                        <td>Visų dantų balinimas lazeriu</td>
                        <td style="text-align: center;">180</td>
                    </tr>
                    <tr>
                        <td>Dantų balinimas klinikoje Philips ZOOM sistema (+ namų rinkinys)</td>
                        <td style="text-align: center;">290</td>
                    </tr>
                    <tr>
                        <td>Dantų balinimas kapomis namuose (antspaudai, 2 kapos , 1 balinimo švirkštas)</td>
                        <td style="text-align: center;">130</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
