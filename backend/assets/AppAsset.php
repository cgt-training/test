<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/material-dashboard.css',
        'css/demo.css',
        
    ];
    public $js = [
        'js/jquery-3.1.0.min.js',
        'js/bootstrap.min.js',
        'js/material.min.js',
        'js/chartist.min.js',
        'js/bootstrap-notify.js',
        'assets/js/material-dashboard.js',
        'assets/js/demo.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
