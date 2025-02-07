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
        'css/datatables.bundle.css',
        'css/vis-timeline.bundle.css',
        'css/plugins.bundle.css',
        'css/style.bundle.css',
    ];
    public $js = [
      "js/plugins.bundle.js", 
      "js/scripts.bundle.js",
      "js/datatables.bundle.js",
      "js/vis-timeline.bundle.js",
      "js/widgets.bundle.js",  
      "js/widgets.js",  
      "js/chat.js",  
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
