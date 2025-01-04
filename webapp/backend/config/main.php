<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ]
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'extraPatterns' => [
                        'POST register' => 'register',
                        'POST login' => 'login',
                        'POST reset-password' => 'reset-password',
                        'DELETE fulldelete/{id}' => 'fulldelete'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/userprofile',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/servico',
                    'extraPatterns' => [
                        'GET count' => 'count',
                        'GET filter/{minPrice}/{maxPrice}/{minDuration}/{maxDuration}' => 'filter',
                    ],
                    'tokens' => [
                        '{minPrice}' => '<minPrice:[^/]*>', 
                        '{maxPrice}' => '<maxPrice:[^/]*>',
                        '{minDuration}' => '<minDuration:[^/]*>',
                        '{maxDuration}' => '<maxDuration:[^/]*>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinhoservico',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/linhacarrinhoservico',
                    'extraPatterns' => [
                        'GET carrinhoservico_id/{id}' => 'getbycarrinhoservicoid',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favorito',
                    'extraPatterns' => [
                        'GET userprofile_id/{id}' => 'getbyuserprofileid',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/fatura',
                    'extraPatterns' => [
                        'GET userprofile_id/{id}' => 'getbyuserprofileid',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/linhafatura',
                    'extraPatterns' => [
                        'GET fatura_id/{id}' => 'getbyfaturaid',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/review',
                    'extraPatterns' => [
                        'GET servico_id/{id}' => 'servicoid',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
            ],
        ],

    ],
    'params' => $params,
];
