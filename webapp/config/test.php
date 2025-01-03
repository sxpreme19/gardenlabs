<?php

return [
    'id' => 'app-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=gardenlabstests',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];
