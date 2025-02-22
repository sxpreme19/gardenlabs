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
                        '{minDuration}' => '<minDuration:[^/]*>',
                        '{maxDuration}' => '<maxDuration:[^/]*>',
                        '{minPrice}' => '<minPrice:[^/]*>', 
                        '{maxPrice}' => '<maxPrice:[^/]*>',
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
                        'POST addtocart' => 'addtocart',
                        'GET carrinhoservico_id/{id}' => 'getbycarrinhoservicoid',
                        'DELETE removefromcart/{id}' => 'removefromcart',
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
                        'GET {id}' => 'id',
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
                        'GET servico_id/{id}' => 'getbyservicoid',
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
