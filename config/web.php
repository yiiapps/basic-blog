<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@funson86' => '@vendor/yiiexttbq',
        '@yiiexttbq/adminblog' => '@vendor/yiiexttbq/blogmodule',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'PVGxVtVt65FelFNX001Px6LI5kDFLqoO',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
            ],
        ],
    ],
    'params' => $params,

    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
];

$config['modules']['admin'] = [
    'class' => 'yiiexttbq\adminlte\Module',
    'layout' => 'main',
    'menus' => [], //详见 mdmsoft/yii2-admin
];
$config['components']['user'] = [
    'identityClass' => 'mdm\admin\models\User',
    'loginUrl' => ['admin/user/login'],
    'enableAutoLogin' => false,
];
$config['components']['authManager'] = [
    'class' => 'yii\rbac\DbManager',
];
$config['as access'] = [
    'class' => 'mdm\admin\components\AccessControl',
    'allowActions' => [
        'site/*',
        'blog/*',
    ],
];

//管理端
$config['modules']['adminblog'] = [
    'class' => 'yiiexttbq\blogmodule\Module',
    'controllerNamespace' => 'yiiexttbq\blogmodule\controllers\backend',
];
//frontend
$config['defaultRoute'] = 'blog';
$config['modules']['blog'] = [
    'class' => 'funson86\blog\Module',
    'controllerNamespace' => 'funson86\blog\controllers\frontend',
];
$config['aliases']['@common/models'] = '@app/common/models';

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
