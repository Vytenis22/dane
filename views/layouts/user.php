<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<link rel="shortcut icon" href="/fav_tooth.ico" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title = 'Danės klinika') ?></title>
	<? //require_once 'header.php'; ?>
	
	<script>
	function startTime() {
	  var today = new Date();
	  var h = today.getHours();
	  var m = today.getMinutes();
	  var s = today.getSeconds();
	  m = checkTime(m);
	  s = checkTime(s);
	  document.getElementById('txt').innerHTML =
	  h + ":" + m + ":" + s;
	  var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
	  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	  return i;
	}
	</script>
	<script type="text/javascript"> 
		function display_c(){
			var refresh=1000; // Refresh rate in milli seconds
			mytime=setTimeout('display_ct()',refresh)
		}

		function display_ct() {
			var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
			var x = new Date()
			document.getElementById('ct').innerHTML = x.toLocaleString('lt-LT', options);
			display_c();
		 }
	</script>
	
    <?php $this->head() ?>
</head>

<body onload="display_ct()">
<?php $this->beginBody() ?>

<div id="header">
	<div class="content">
			<!-- <img src="../../web/images/logo-danes.png" alt="Danes klinika" width="170px" height="100px" class="center"> -->
			<?= 
				/*Html::a(Html::img(Url::to('@web/images/logo-danes.png'), ['alt' => 'Danės klinika', 'width'=>'190', 'height'=>'120']), ['site/index'], ['class' => 'logo-danes']);*/
				Html::a(Html::img(Url::to('@web/images/logo-danes.png'), ['alt' => 'Danės klinika']), ['site/index'], ['class' => 'logo-danes']);
			?>

		<div class="ri">
			<li>
				<?php
				if (Yii::$app->user->isGuest){
					echo Html::a(Yii::t('app', 'Online reservation'), Url::to(['/copy/reservation']), ['class' => 'btn btn-primary']);
				} 
				?>
			</li>
		</div>
		<div class="risid">
			<ul class="lang">
				<?php
					foreach (Yii::$app->params['languages'] as $key => $language) {

						echo	'<li id="'. $key .'" value="'.Url::to(['site/language', 'lang' => $key]).'">'
														.
															Html::img(Url::to('@web/images/'. $key .'_flag.jpg'), ['alt' => 'Danės klinika'])
														.														
													'</li>';
					}
				?>
			</ul>
			<div class="teltop">
				<span>Klaipėda</span>
				<a href="tel:0037065763203">8 657 63203</a>
			</div>
		</div>

		<!-- <div class="header-right">
			<div class="toptel">
				<span>Silute</span>
				<a href="tel:0037065763203">8 657 63203</a>
			</div>
			<div class="toptel">
				<span>Klaipeda</span>
				<a href="tel:0037065788701">8 657 88701</a>
			</div>
		</div> -->
	</div>
	
</div>


<!--
<div class="header">
	
	<div class="header-right">
	<img src="../../web/images/logo-danes.png" width="90px" height="80px">
    <a class="active" href="<?= Yii::$app->name ?>">Home</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a>
	<div class="teltop">
		<span>Silute</span>
		<a href="tel:0037065763203">8 657 63203</a>
	</div>
	<div class="teltop">
		<span>Klaipeda</span>
		<a href="tel:0037065788701">8 657 88701</a>
	</div>
	</div>
</div> 
-->

<div class="wrap">

	<!-- <a href="#" class="navbar-left"><img src="/logo-danes.png"></a> -->
	
	<div id="antraste-navbar">

    <?php	
	
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
		//'brandLabel' => Html::img('@web/images/logo-danes.png', ['alt'=>Yii::$app->name]),
        //'brandUrl' => Yii::$app->homeUrl,
		'brandUrl' => ['/site/index'],
        'options' => [
            'class' => 'navbar-inverse navbar-static-top',
        ],
    ]);
	
	$navItemsUser=[

	   ['label' => Yii::t('app', 'Patients'), 'url' => ['/patient/index']],

	   ['label' => Yii::t('yii', 'Timetable'), 'url' => ['/visit/timetable']],    

	   /*['label' => Yii::t('user', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 
	   		'linkOptions' => ['data-method' => 'post']], */  

	 ];
 
	 if (Yii::$app->user->can('manageServices')) 
		{		
	 		array_push($navItemsUser, ['label' => Yii::t('app', 'Services'), 'url' => ['/services/index']]);
		}

	 	if (Yii::$app->user->can('manageMaterials'))
	 	{
			array_push($navItemsUser, ['label' => Yii::t('app', 'Materials'), 'url' => ['/material/index']]);
		}

	 	if (Yii::$app->user->can('manageUsers'))
	 	{
			array_push($navItemsUser, ['label' => Yii::t('yii', 'Users'), 'url' => ['/user/admin/index']]);
		}

		if (!Yii::$app->user->isGuest) {

			array_push($navItemsUser,
				['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
				['label' => Yii::t('user', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',

	       'url' => ['/site/logout'],

	       'linkOptions' => ['data-method' => 'post']]);

		}
 

echo Nav::widget([

   'options' => ['class' => 'navbar-nav navbar-right'],

   'items' => $navItemsUser,

]);
	
	/*
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
	*/
    NavBar::end();
    ?>

	</div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>	
	
</div>

<script>
	window.onscroll = function() {myFunction()};

	var navbar = document.getElementById("antraste-navbar");
	var sticky = navbar.offsetTop;

	function myFunction() {
	  if (window.pageYOffset >= sticky) {
	    navbar.classList.add("sticky")
	  } else {
	    navbar.classList.remove("sticky");
	  }
	}
</script>

<footer class="footer">
    <div class="container">
        <!-- <p class="pull-left">&copy; My Company <?= date('Y') ?></p> 
		<p id="txt" class="pull-left" ></p>
		-->
		
		<p id="ct" class="pull-left" ></p>
		
		 <!-- <div id="txt"></div> -->

       <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
