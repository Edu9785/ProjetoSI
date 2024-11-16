<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/styles.css'
    ];

    public $js = [
        'lib/easing/easing.min.js',
        'lib/owlcarousel/owl.carousel.min.js',
        'mail/jqBootstrapValidation.min.js',
        'mail/contact.js',
        'js/main.js',
        'https://code.jquery.com/jquery-3.4.1.min.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();
        \Yii::$app->view->registerLinkTag(['rel' => 'icon', 'href' => '@web/img/favicon.ico']);

        \Yii::$app->view->registerLinkTag([
            'rel' => 'stylesheet',
            'href' => 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap'
        ]);

        \Yii::$app->view->registerLinkTag([
            'rel' => 'stylesheet',
            'href' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css'
        ]);

        \Yii::$app->view->registerLinkTag([
            'rel' => 'preconnect',
            'href' => 'https://fonts.gstatic.com',
        ]);
    }
}
