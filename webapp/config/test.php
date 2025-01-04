<?php

return [
    'id' => 'app-tests',
    'basePath' => dirname(__DIR__),
    'components' => [   
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => 'http://localhost/gardenlabs/webapp',
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=gardenlabstests',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];
