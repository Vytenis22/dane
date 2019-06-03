<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\assets\PrintAsset;
use yii\web\View;

PrintAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Recipes */
?>
<div class="print">

    <p class="respublika">
        Lietuvos Respublikos
        <br>
        sveikatos apsaugos ministerija
    </p>

    <p class="danes-init" style="width: 100%; float: left; display: block;">
        UAB "SVEIKATOS GIJA", 301206554
        <br>
        Danės g. 21, Klaipėda, Lietuva, +37065788701, klaipeda@danesklinika.lt
    </p>
    <div class="cnt">
        <h1>Receptas</h1>
    </div>
    <p id="paciento-duomenys">
        Paciento duomenys
    </p>
    <table class="cnt">
        <tbody>
            <tr>
                <td><strong><?= $recipe->patient->name ?></strong></td>
                <td><strong><?= $recipe->patient->surname ?></strong></td>
                <td class="last-td"><strong><?= $recipe->patient->birth_date ?></strong></td>                
            </tr>
            <tr>
                <td>Vardas</td>
                <td>Pavardė</td>
                <td>Gimimo data</td>  
            </tr>
            <tr class="adresas">
                <td colspan="3">
                    <strong><?= $recipe->patient->address . ", " . $recipe->patient->cityName ?></strong>
                </td>
            </tr>
            <tr class="adrsabl">
                <td colspan="3">
                    Adresas (gatvė, namo numeris, miestas, savivaldybė, valstybė) arba ambulatorinės kortelės numeris
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Rp.
                </td>
                <td>
                    Kaina
                </td>
            </tr>
            <tr class="rp">
                <td colspan="2">
                    <?= $recipe->rp ?>
                    <br>
                    D.t.d. N: <?= $recipe->N ?>
                    <br>
                    S.: <?= $recipe->S ?>                  
                </td>
                <td>
                    
                </td>
            </tr>           
        </tbody>
    </table>
    <table class="cnt">
        <tbody>
            <tr class="dat">
                <td class="first-td">Išrašymo data</td>
                <td class="sec-td"><?= date('Y-m-d', strtotime($recipe->create_at)) ?></td>
                <td class="first-td">Galioja iki</td>
                <td class="sec-td"><?= $recipe->expire ?></td>
            </tr>
        </tbody>
    </table>
    <table id="spaudas" class="cnt">
        <tbody>
            <tr class="dat2">
                <td class="first-td">Gydytojo spaudas, parašas, telefonas (su tarptautiniu kodu) ir el. paštas arba faksas (su tarptautiniu kodu)</td>
                <td></td>
            </tr>
            <tr class="dat3">
                <td class="first-td">Vaistinės spaudas<br>
                    "Vaistai išduoti...vaistinėje" (vaistinės, jos filialo pavadinimas), duomenys apie faktiškai išduotą (parduotą) vaistą (vaisto prekinis pavadinimas, stiprumas bei dozuočių kiekis) <br>
                    vaistų išdavimo (pardavimo) data, vaistą išdavusio (pardavusio) farmacijos specialisto spaudas ir parašas
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

</div>
