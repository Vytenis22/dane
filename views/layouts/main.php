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
<!-- <html lang="<?= Yii::$app->language ?>"> -->
<html>

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
<?php 

$this->beginBody() ?>

<div id="header">
	<div class="content">
			<!-- <img src="../../web/images/logo-danes.png" alt="Danes klinika" width="170px" height="100px" class="center"> -->
			<?= 
				/*Html::a(Html::img(Url::to('@web/images/logo-danes.png'), ['alt' => 'Danės klinika', 'width'=>'190', 'height'=>'120']), ['site/index'], ['class' => 'logo-danes']);*/
				Html::a(Html::img(Url::to('@web/images/logo-danes.png'), ['alt' => 'Danės klinika']), Yii::$app->user->isGuest ? ['/site/index'] : (\Yii::$app->user->can('viewVisit') ? ['/visit/timetable'] : ['/patient/visits', 'id' => \Yii::$app->user->id]), ['class' => 'logo-danes']);
			?>

		<?php
			if (Yii::$app->user->isGuest){
			?>
				<!-- <div class="ri">
					<li>
						<?php
							echo Html::a(Yii::t('app', 'Online reservation'), Url::to(['/copy/reservation']), ['class' => 'btn btn-primary']);
						?>
					</li>
				</div> -->
			<?php 
			}
			?>
		<div class="risid">
			<ul class="lang">
				<?php
					foreach (Yii::$app->params['languages'] as $key => $language) {

						echo	'<li id="'. $key .'" value="'.Url::to(['/site/language', 'lang' => $key]).'">'
														.
															Html::img(Url::to('@web/images/'. $key .'_flag.jpg'), ['alt' => 'Danės klinika'])
														.														
													'</li>';
					}
				?>


				 <!-- <li id='' value="'.Url::to(['site/language', 'lang' => $key]).'">
					<?=
						Html::img(Url::to('@web/images/flag_lt_new.jpg'), ['alt' => 'Danės klinika'])
					?>
					 <img alt="Odontologijos klinikos svetainė" src="flag_lt_new.jpg">
				</li>
				<li id="'.$key.'" value="'.Url::to(['site/language', 'lang' => $key]).'">
					<?=
						Html::a(Html::img(Url::to('@web/images/flag_en_new.jpg'), ['alt' => 'Danės klinika']), Url::to(['/']));
						//Html::img(Url::to('@web/images/flag_en_new.jpg'), ['alt' => 'Danės klinika'])
					?>
					 <a href="/en/" title="English">
						<img alt="English" src="flag_en_new.jpg">
					</a> 
				</li> 
 -->


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
		'brandUrl' => Yii::$app->user->isGuest ? ['/site/index'] : (\Yii::$app->user->can('viewVisit') ? ['/visit/timetable'] : ['/patient/visits', 'id' => \Yii::$app->user->id]),
        'options' => [
        	'class' => 'navbar navbar-inverse',
            //'class' => 'navbar-inverse navbar-static-top',
            //'class' => 'navbar-inverse  navbar-default navbar-fixed-top',
        ],
    ]);
	
	$navItems=[

   ['label' => Yii::t('yii', 'About'), 'url' => ['/site/about']], 

   ['label' => Yii::t('yii', 'Personnel'), 'url' => ['/site/personnel']],  

   ['label' => Yii::t('yii', 'Prices'), 'url' => ['/site/prices']],
   
   ['label' => Yii::t('app', 'Services'), 'url' => ['/site/services']],    

   ['label' => Yii::t('yii', 'Contact'), 'url' => ['/site/contact']],      

   ['label' => Yii::t('user', 'Sign in'), 'url' => ['/user/login']],      

   ['label' => Yii::t('user', 'Sign up'), 'url' => ['/user/register']],  

 ];

 	$navItemsPatient=[

	['label' => Yii::t('yii', 'Reservation'),  
	    'url' => ['#'],
	    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
	    'options' => ['class' => 'nav navbar-nav navbar-inverse'],
	    'items' => [
	        ['label' => Yii::t('yii', 'Register'), 'url' => Url::to(['copy/reservation']),'options'=>['class'=>'navbar-drop']],
	        '<li class="divider"></li>',
	        ['label' => Yii::t('yii', 'Cancel reservation'), 'url' => Url::to(['/site/request']),'options'=>['class'=>'navbar-drop']],
	    ],
	], 

   /*['label' => Yii::t('user', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 
   		'linkOptions' => ['data-method' => 'post']], */  

 	];

 	$navItemsUser=[

	['label' => Yii::t('app', 'Visits search'), 'url' => ['/visit/visits-list']],

	['label' => Yii::t('app', 'Patients'), 'url' => ['/patient/index']],

	['label' => Yii::t('yii', 'Timetable'), 'url' => ['/visit/timetable']],    

   /*['label' => Yii::t('user', 'Logout') . ' (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 
   		'linkOptions' => ['data-method' => 'post']], */  

 	];

 	if (Yii::$app->user->can('manageServices')) 
	{		
 		array_push($navItemsUser, 
 			['label' => Yii::t('app', 'Manage Services'),  
			    'url' => ['#'],
			    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
			    'options' => ['class' => 'nav navbar-nav navbar-inverse'],
			    'items' => [
			        ['label' => Yii::t('app', 'Services'), 'url' => ['/services/index'],'options'=>['class'=>'navbar-drop']],
			        '<li class="divider"></li>',
			        ['label' => Yii::t('app', 'Materials'), 'url' => ['/material/index'],'options'=>['class'=>'navbar-drop']],
			    ],
			]);
	}

	/*if (Yii::$app->user->can('manageServices')) 
	{		
 		array_push($navItemsUser, ['label' => Yii::t('app', 'Services'), 'url' => ['/services/index']]);
	}

 	if (Yii::$app->user->can('manageMaterials'))
 	{
		array_push($navItemsUser, ['label' => Yii::t('app', 'Materials'), 'url' => ['/material/index']]);
	}*/

	if (Yii::$app->user->can('manageUsers')) 
	{		
 		array_push($navItemsUser, 
 			['label' => Yii::t('app', 'Manage Users'),  
			    'url' => ['#'],
			    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
			    'options' => ['class' => 'nav navbar-nav navbar-inverse'],
			    'items' => [
			        ['label' => Yii::t('yii', 'Users'), 'url' => ['/user/admin/index'],'options'=>['class'=>'navbar-drop']],
			        '<li class="divider"></li>',
			        ['label' => Yii::t('app', 'Vacations'), 'url' => ['vacations/index'],'options'=>['class'=>'navbar-drop']],
			    ],
			]);
	}

 	/*if (Yii::$app->user->can('manageUsers'))
 	{
		array_push($navItemsUser, ['label' => Yii::t('yii', 'Users'), 'url' => ['/user/admin/index']]);
	}*/

	if (!Yii::$app->user->isGuest) {
		if (is_null(Yii::$app->user->identity->profile->name)) {
			$username = Yii::$app->user->identity->username;
		} else {
			$user = Yii::$app->user->identity->profile->name;
			$user_expl = explode(" ", Yii::$app->user->identity->profile->name);
			$username = $user_expl[0];
		}

		array_push($navItemsPatient,

			['label' => Yii::t('app', 'My History'),  
			    'url' => ['#'],
			    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
			    'options' => ['class' => 'nav navbar-nav navbar-inverse'],
			    'items' => [
			        ['label' => Yii::t('app', 'My Card'), 'url' => ['patient/view-patient', 'id' => Yii::$app->user->id],'options'=>['class'=>'navbar-drop']],
			        '<li class="divider"></li>',
			        ['label' => Yii::t('app', 'My Visits'), 'url' => ['patient/visits', 'id' => Yii::$app->user->id],'options'=>['class'=>'navbar-drop']],
			    ],
			], 

			['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
			//['label' => Yii::t('user', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
			['label' => Yii::t('user', 'Logout') . ' (' . $username . ')',

       'url' => ['/site/logout'],

       'linkOptions' => ['data-method' => 'post']]);

		array_push($navItemsUser,

			['label' => Yii::t('app', 'My History'),  
			    'url' => ['#'],
			    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
			    'options' => ['class' => 'nav navbar-nav navbar-inverse'],
			    'items' => [
			        ['label' => Yii::t('app', 'My Card'), 'url' => ['patient/view-patient', 'id' => Yii::$app->user->id],'options'=>['class'=>'navbar-drop']],
			        '<li class="divider"></li>',
			        ['label' => Yii::t('app', 'My Visits'), 'url' => ['patient/visits', 'id' => Yii::$app->user->id],'options'=>['class'=>'navbar-drop']],
			        '<li class="divider"></li>',
			        ['label' => Yii::t('app', 'Vacations'), 'url' => ['vacations/my-vacations'],'options'=>['class'=>'navbar-drop']],
			    ],
			], 

			/*['label' => Yii::t('app', 'My Card'), 'url' => ['patient/view-patient', 'id' => Yii::$app->user->id]],

			['label' => Yii::t('app', 'My Visits'), 'url' => ['patient/visits', 'id' => Yii::$app->user->id]],*/

			['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
			//['label' => Yii::t('user', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
			['label' => Yii::t('user', 'Logout') . ' (' . $username . ')',

       'url' => ['/site/logout'],

       'linkOptions' => ['data-method' => 'post']]);

	}
 

 /*if (Yii::$app->user->isGuest) {

   array_push($navItems,['label' => Yii::t('user', 'Sign in'), 'url' => ['/user/login']]);

 } else {
	 
	 //if (Yii::$app->user->identity->username == 'admin') {
 		if (Yii::$app->user->can('manageUsers')) {
		 
	   array_push($navItems, ['label' => Yii::t('yii', 'Users'), 'url' => ['/user/admin/index']]);
   } else {
	   array_push($navItems, ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']]);
   }

   array_push($navItems, ['label' => Yii::t('app', 'Patients'), 'url' => ['/patient/index']],
	    ['label' => 'Grafikas', 'url' => ['/visit/timetable']],
   
		['label' => Yii::t('user', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',

       'url' => ['/site/logout'],

       'linkOptions' => ['data-method' => 'post']]
	   
	   

   );

 }*/

 if (Yii::$app->user->isGuest) 
 {
 	echo Nav::widget([

		'options' => ['class' => 'navbar-nav navbar-right'],

		'items' => $navItems,

		'activateParents' => true,

	]);
 } elseif (Yii::$app->user->can('viewVisit'))
 {
 	echo Nav::widget([

		'options' => ['class' => 'navbar-nav navbar-right'],

		'items' => $navItemsUser,

		'activateParents' => true,

	]);
 } else 
 {
 	echo Nav::widget([

		'options' => ['class' => 'navbar-nav navbar-right'],

		'items' => $navItemsPatient,

		'activateParents' => true,

	]);
 }

/*echo Nav::widget([

   'options' => ['class' => 'navbar-nav navbar-right'],

   'items' => Yii::$app->user->isGuest ? $navItems : (Yii::$app->user->can('createReservation') ? $navItemsPatient : $navItemsUser),

   'activateParents' => true,

]);*/
	
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

<!--
<script>
	$(document).on('click', '.language', function() {
		var lang = $(this).attr('id');
		
		$.post(".Url::toRoute('/site/language', true).", {'lang':lang}, function(data) {
			location.reload();
		});
	});
</script>
-->

<?php
	if (Yii::$app->user->isGuest) {
		?>
		<div id="fmen">
			<div class="cnt">
				<ul>
					<li><?= Html::a(Yii::t('yii', 'About'), Url::to(['/site/about'])); ?></li>
					<li><?= Html::a(Yii::t('app', 'Personnel'), Url::to(['/site/personnel'])); ?></li>
					<li><?= Html::a(Yii::t('yii', 'Prices'), Url::to(['/site/prices'])); ?></li>
					<li><?= Html::a(Yii::t('app', 'Services'), Url::to(['/site/services'])); ?></li>
					<li><?= Html::a(Yii::t('yii', 'Register'), Url::to(['/copy/reservation'])); ?></li>
					<li><?= Html::a(Yii::t('app', 'Cancel reservation'), Url::to(['/site/request'])); ?></li>
					<li><?= Html::a(Yii::t('yii', 'Contact'), Url::to(['/site/contact'])); ?></li>
				</ul>
			</div>
		</div>
		<?php
	}
	?>



<footer id="footer">
    <div class="container">
        <!-- <p class="pull-left">&copy; My Company <?= date('Y') ?></p> 
		<p id="txt" class="pull-left" ></p>
		-->
		
		<p id="ct" class="pull-left" ></p>
		
		<div class="languages">
		<!-- <p class="pull-right">
		
		<?php
		
			foreach (Yii::$app->params['languages'] as $key => $language) {
				echo '<span class="language btn btn-link" id="'.$key.'" value="'.Url::to(['site/language', 'lang' => $key]).'">'.$language.' | </span>';
			}
		?>	

			
		</p> -->
		</div>
		
		 <!-- <div id="txt"></div> -->

       <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
