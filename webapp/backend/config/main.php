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
                ['class' => 'yii\rest\UrlRule','controller' => 'api/user'],
                [
                    'class' => 'yii\rest\UrlRule','controller' => 'api/produto',
                    'extraPatterns' => [
                        'GET count' => 'count',
                        'GET nomes' => 'nomes',
                        'GET {id}/preco' => 'preco',
                        'GET preco/{nomeproduto}' => 'precopornome',
                        'DELETE {nomeproduto}' => 'delpornome',
                        'PUT {nomeproduto}' => 'putprecopornome',
                        'POST vazio' => 'postprodutovazio',
                        'GET {data_criacao}' => 'data_criacao',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{nomeproduto}' => '<nomeproduto:[\\w ]+>',
                        '{data_criacao}' => '<data_criacao:\\d{4}-\d{2}-\d{2}+>'
                    ],    
                ],
            ],
        ],
        
    ],
    'params' => $params,
];
