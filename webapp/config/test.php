<?php

return [
    'id' => 'app-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '/gardenlabs/webapp',
            'enablePrettyUrl' => false,
            'showScriptName' => false,
        ],
        'request' => [
            'hostInfo' => 'http://localhost',
            'baseUrl' => '/gardenlabs/webapp',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=gardenlabstests',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
    ],
];

