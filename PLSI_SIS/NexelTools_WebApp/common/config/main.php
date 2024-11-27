<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@uploads' => '@backend/web/uploads',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,

        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
