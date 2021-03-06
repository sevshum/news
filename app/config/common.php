<?php
require_once __DIR__ . '/../modules/core/helpers/common.php';
return [
    'id' => 'cms',
    'name' => 'CMS',
    'sourceLanguage' => 'en',
    'vendorPath' => __DIR__ . '/../../vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'modules' => [
        'rbac' => ['class' => 'app\modules\rbac\Module'],
        'admin' => ['class' => 'app\modules\admin\Module'],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'language' => ['class' => 'app\modules\language\Module'],
        'settings' => ['class' => 'app\modules\settings\Module'],
        'menu' => ['class' => 'app\modules\menu\Module'],
        'mail' => ['class' => 'app\modules\mail\Module'],
        'comment' => ['class' => 'app\modules\comment\Module'],
        'category' => ['class' => 'app\modules\category\Module'],
        'blog' => ['class' => 'app\modules\blog\Module'],
        'attachment' => ['class' => 'app\modules\attachment\Module'],
        'notifications' => ['class' => 'app\modules\notifications\Module'],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        'consoleRunner' => [
            'class' => 'app\modules\core\components\ConsoleRunner',
            'rootPath' => __DIR__ . '/../..'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
//        'authClientCollection' => [
//            'class' => 'yii\authclient\Collection',
//            'clients' => [
//                'google' => ['class' => 'yii\authclient\clients\GoogleOAuth'],
//                'facebook' => ['class' => 'yii\authclient\clients\Facebook'],
//                'vkontakte' => ['class' => 'app\modules\user\components\auth\VKontakte'],
//            ],
//        ]
    ],
    'params' => [
        'backend-link' => '/backend.php'
    ]
];
