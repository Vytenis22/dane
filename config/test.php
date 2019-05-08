<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            //'useFileTransport' => true,
			
			'class' => 'yii\swiftmailer\Mailer',
 
			'viewPath' => '@app/mailer',
 
			'useFileTransport' => false, 
			
			'transport' => [
 
				'class' => 'Swift_SmtpTransport',
 
				'host' => 'smtp.gmail.com',
 
				'username' => 'dionizas123@gmail.com',
 
				'password' => 'kakalasa5',
 
				'port' => '587',
 
				'encryption' => 'tls',
 
			],		
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
