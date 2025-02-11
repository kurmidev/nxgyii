<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.css',
        'css/chartjs.css',
        'css/simplebar.css',
        'css/style.css',
    ];
    public $js = [
      "js/bundle.min.js", 
      "js/chart.umd.js",
      "js/chartjs.js",
      "js/color-modes.js",
      "js/simplebar.min.js",  
      "js/utils.js",  
      "js/main.js",  
      "js/index.js",  
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
