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
        //        'css/site.css',
        "css/font-face.css",
        "vendor/font-awesome/css/font-awesome.min.css",
        "vendor/linearicons-free/css/linearicons-free.css",
        "vendor/elegant-icons/css/elegant-icons.css",
        "vendor/bootstrap/bootstrap.min.css",
        "vendor/animate.css/animate.min.css",
        "vendor/css-hamburgers/hamburgers.min.css",
        "vendor/slick/slick.css",
        "vendor/animsition/animsition.min.css",
        "vendor/lightbox/css/lightbox.min.css",
        "vendor/revolution/css/layers.css",
        "vendor/revolution/css/navigation.css",
        "vendor/revolution/css/settings.css",
        "css/theme.css",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.0/jquery.fancybox.min.css",
//        "css/jquery.fancybox.css"

    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
