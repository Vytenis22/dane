<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Times';
$this->params['breadcrumbs'][] = Yii::t('yii', $this->title);
?>
<div class="site-times">
    <h1><?= Html::encode(Yii::t('yii', $this->title)) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>


	
	<?php

    echo "<option value=''>Pasirinkite laiką…</option>";
    if(!empty($time_slots)){
        foreach($time_slots as $slot){
            echo "<option value='$slot'>$slot</option>";
        }
    }
    else{
        //echo "<option>Visi laikai užimti</option>";
        echo "<option value='' disabled selected hidden>Visi laikai užimti</option>";
    }

    var_dump($duration_obj->duration);
    var_dump($time_slots);
    echo (!empty($time_slots) ? "masyvas ne tuscias" : "masyvas tuscias" );
	
	?>

    <code><?= __FILE__ ?></code>
</div>
