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
        'css/site.css',
        'css/bootstrap.min.css',
        'css/style.css',
        'css/responsive.css',
        'css/custom.css',
    ];
    public $js = [
        'js/jquery-3.2.1.min.js',
        'js/popper.min.js',       
        'js/bootstrap.min.js',     
        'js/baguetteBox.min.js',
        'js/bootsnav.js',
        'js/bootstrap-select.js',
        'js/form-validator.min.js',
        'js/contact-form-script.js',
        'js/custom.js',            
        'js/images-loded.min.js',
        'js/inewsticker.js',
        'js/isotope.min.js',
        'js/jquery-ui.js',
        'js/jquery.nicescroll.min.js',
        'js/jquery.superslides.min.js',
        'js/owl.carousel.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
