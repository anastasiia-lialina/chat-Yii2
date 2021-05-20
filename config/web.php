<?php

use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'chat',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'name' => 'Chat',
    'homeUrl' => '/messages/index',
    'defaultRoute' => '/messages/index',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'hia2sA_rlkdWncGAXWOAvr7UigYpnOZJ',
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => [
                    'class' => JsonParser::class,
                    'asArray' => true,
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
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
        'formatter' => [
            'defaultTimeZone' => 'UTC',
            'timeZone' => 'Europe/Moscow',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [
                'guest'
            ]
        ],
        'i18n' => [
            'translations' => [
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/languages',
                    'sourceLanguage' => 'en-US'
                ],
            ],
        ],

    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'top-menu',
            'mainLayout' => '@app/views/layouts/main.php',
            'menus' => [
                'assignment' => [
                    'label' => 'Пользователи'
                ],
                'route' => null,
                'permission' => null,
                'rule' => null,
                'role' => null
            ],
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\Users',
                    'usernameField' => 'username',
                ],
            ],
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => []
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        //TODO DELETE THIS
        'allowedIPs' => ['*'],
    ];
}

return $config;
