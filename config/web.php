<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@modules' =>  '@app/modules',
    ],
    'modules' => [
        'auth' => [
            'class' => 'app\modules\auth\Module',
        ],
        'forms' => [
            'class' => 'app\modules\forms\Module',
        ],
        'report' => [
            'class' => 'app\modules\report\Module',
        ],
        'cron' => [
            'class' => 'app\modules\cron\Module',
        ],
        'report-app' => [
            'class' => 'app\modules\report_app\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'uOov3JLabZeX3ju0xl0CToNM2MlbBBop',
            'baseUrl'=> '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['main/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => '/order/installment',
                '/<action:(index|students)>' => '/main/<action>',
                '/<action:(login|logout|reset|sign-up)>' => 'auth/main/<action>',
                '/<controller:profile>' => 'profile/index',
                '/<controller:profile>/<action:(index|service|requisite|bank-detail|address|settings|save-settings)>' => 'profile/<action>',
                '/<controller:profile>/<action:(create|edit|delete)>' => 'profile/<action>',
                '/<controller:service>' => 'service/index',
                '/<controller:service>/<action:(index|create|edit|delete)>' => 'service/<action>',
                '<module>/<controller>/<acttion>' => '<module>/<controller>/<acttion>',
                '/report/<action>' => '/report/main/<action>',
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
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
