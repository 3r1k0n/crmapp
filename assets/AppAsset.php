<?php

namespace app\assets;
use yii\web\AssetBundle;

/**
 * Main asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yidas\yii\bootstrap\BootstrapAsset',
    ];
}