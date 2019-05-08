<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [

	'modules' => [
	   'user' => [
		   'class' => 'dektrium\user\Module',
	   ],
	],

	/**'modules' => [
		'rbac' => 'dektrium\rbac\RbacConsoleModule',
	],*/

    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
		
		'mailer' => [		
			'class' => 'yii\swiftmailer\Mailer', 
			'useFileTransport' => false,  
			'viewPath' => '@app/mail',			
			'transport' => [ 
				'class' => 'Swift_SmtpTransport', 
				'host' => 'smtp.gmail.com', 
				'username' => 'dionizas123@gmail.com', 
				'password' => 'kakalasa5', 
				'port' => '587', 
				'encryption' => 'tls', 
			],							
        ],
		
		/**	
		'request' => array(
			'hostInfo' => 'http://localhost',
			'baseUrl' => '',
			'scriptUrl' => '',
		),
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'<controller:\w+>' => '<controller>/index',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),*/
	
		'urlManager' => [
			'hostInfo' => 'http://localhost/dane/web',

            //'baseUrl'   => 'http://localhost/dane/web',

            //'scriptUrl' => 'localhost/dane/web',
			'scriptUrl' => '',
			'enablePrettyUrl' => true,
			//'showScriptName' => false,
			/**
            'rules' => [

                'online-betalen/<invoice_number>/<hash>'   => 'invoice/online-payment',

            ],
			*/
        ],
	
		'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
	
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
