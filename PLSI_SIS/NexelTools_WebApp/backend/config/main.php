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
        ],
    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    'backend/views' => '@vendor/hail812/yii2-adminlte3/src/views'
                ]
            ]
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
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
                        'POST login' => 'login',
                        'POST registar' => 'registar'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/metodoexpedicao',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/metodopagamento',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/categoria',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/profile',
                    'extraPatterns' => [

                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/fatura',
                    'extraPatterns' => [
                        'GET userfaturas/{id_profile}' => 'userfaturas'
                    ],
                    'tokens' =>[
                        '{id_profile}' => '<id_profile:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/produto',
                    'extraPatterns' => [
                        'GET {nome}' => 'nome',
                        'GET procurarvendedor/{id}' => 'procurarvendedor',
                        'GET filtrarpreco/{max_preco}' => 'filtrarpreco',
                        'POST criarproduto' => 'criarproduto',
                        'PUT editarproduto/{id}' => 'editarproduto',
                        'DELETE eliminarproduto/{id}' => 'eliminarproduto',
                        'GET produtoimagens' => 'produtoimagens',
                    ],
                    'tokens' => [
                        '{nome}' => '<nome:\\w+>',
                        '{id}' => '<id:\\d+>',
                        '{max_preco}' => '<max_preco:\\w+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/avaliacao',
                    'extraPatterns' => [
                        'GET avaliacaoproduto/{id_produto}' => 'avaliacaoproduto',
                        'GET vendedoravaliacoes/{id_vendedor}' => 'vendedoravaliacoes',
                    ],
                    'tokens' => [
                        '{id_produto}' => '<id_produto:\\d+>',
                        '{id_vendedor}' => '<id_vendedor:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/compra',
                    'extraPatterns' => [
                        'POST fazerCompra'
                    ],
                    'tokens' => [
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favorito',
                    'extraPatterns' => [
                        'GET userfavoritos/{id_user}' => 'userfavoritos',
                    ],
                    'tokens' => [
                        '{id_user}' => '<id_user:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinhocompra',
                    'extraPatterns' => [
                        'POST adicionarproduto/{id_produto}' => 'adicionarproduto',
                        'DELETE removerproduto/{id_linha}' => 'removerproduto',
                    ],
                    'tokens' => [
                        '{id_produto}' => '<id_produto:\\d+>',
                        '{id_linha}' => '<id_linha:\\d+>',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
