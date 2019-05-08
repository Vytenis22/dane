<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$name = "Puslapis nerastas";
$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger col-sm-3">
        <h4><?= $message = "Neteisingai nurodytas adresas."; nl2br(Html::encode($message)) ?></h4>
    </div>

</div>
