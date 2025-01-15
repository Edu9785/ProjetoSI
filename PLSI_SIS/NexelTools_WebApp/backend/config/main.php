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
                        'GET userprofile' => 'userprofile',
                        'PUT editaruserprofile' => 'editaruserprofile',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/fatura',
                    'extraPatterns' => [
                        'GET userfaturas/{id_profile}' => 'userfaturas',
                        'GET getcomprafatura/{id_compra}' => 'getcomprafatura',
                    ],
                    'tokens' =>[
                        '{id_profile}' => '<id_profile:\\d+>',
                        '{id_compra}' => '<id_compra:\\d+>',
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
                        'GET produtoavender' => 'produtoavender',
                        'GET produtosvendidos' => 'produtosvendidos',
                        'GET produtodetalhes/{id}' => 'produtodetalhes',
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
                        'POST checkout' => 'checkout',
                        'GET usercompras' => 'usercompras'
                    ],
                    'tokens' => [
                        
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favorito',
                    'extraPatterns' => [
                        'GET userfavoritos' => 'userfavoritos',
                        'POST addfavorito/{id_produto}' => 'addfavorito',
                        'DELETE removerfavorito/{id_produto}' => 'removerfavorito',
                    ],
                    'tokens' => [
                        '{id_produto}' => '<id_produto:\\d+>',

                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinhocompra',
                    'extraPatterns' => [
                        'GET usercarrinho' => 'usercarrinho',
                        'POST adicionarproduto/{id_produto}' => 'adicionarproduto',
                        'DELETE removerproduto/{id_produto}' => 'removerproduto',
                    ],
                    'tokens' => [
                        '{id_produto}' => '<id_produto:\\d+>',
                        '{id_profile}' => '<id_profile:\\d+>',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
