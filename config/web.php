<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
	
	'modules' => [
	   'user' => [
		   'class' => 'dektrium\user\Module',
		   'admins' => ['admin'],
		   'enableGeneratingPassword' => true,
		   'enableRegistration' => false,
		   'enablePasswordRecovery' => true,
		   'modelMap' => [
				'Patient' => 'models\Patient',
			],
			'modelMap' => [
				'Visit' => 'models\Visit',
			],
		   
		   
		   'controllerMap' => [
				'admin' => [
					'class'  => 'dektrium\user\controllers\AdminController',
					'layout' => '@app/views/layouts/user',
				],
				'settings' => [
					'class'  => 'dektrium\user\controllers\SettingsController',
					'layout' => '@app/views/layouts/user',
				],
			],
			
	   ],
	   /*'session' => [
			'class' => 'yii\web\Session',
			'cookieParams' => ['httponly' => true, 'lifetime' => 10],
			'timeout' => 5, //session expire
			'useCookies' => true,
		],*/
	   //'rbac' => 'dektrium\rbac\RbacWebModule',
	],

    'id' => 'basic',
	'name' => 'Danės klinika',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'language' => 'lt',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	
	//'timeZone' => 'Europe/Vilnius',
	
    'components' => [

    	'formatter' => [
            //'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
		
		'charset'=>'utf-8',
	/**
		'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
	*/
	
		'i18n' => [
			'translations' => [
				'app*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					//'basePath' => '@app/messages',
					//'sourceLanguage' => 'en-US',
					'fileMap' => [
						'app' => 'app.php',
						'app/user' => 'user.php',
						'app/yii' => 'yii.php',
					],
				],
				'yii*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					//'basePath' => '@app/messages',
					//'sourceLanguage' => 'en-US',
					'fileMap' => [
						'yii' => 'yii.php',
					],
				],
				'user*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					//'basePath' => '@app/messages',
					//'sourceLanguage' => 'en-US',
					'fileMap' => [
						'user' => 'user.php',
					],
				],
				/**
				'yii' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'en-US',
					'basePath' => '@app/messages'
				],
				*/
			],
		],
	
		'authManager' => [
            'class' => 'yii\rbac\DbManager',
			'defaultRoles' => ['assistant'],
        ],
	
		'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => ['lifetime' => 60 * 60]
        ],
	
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jkK6P1Yar-9DPArVYD8L1Lm1K5OQ7ELy',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*
		'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
		*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		
			
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
		
		
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
			//'baseUrl' => 'localhost/dane/web',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
		
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
