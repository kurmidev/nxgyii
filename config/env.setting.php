<?php

defined('SITE_NAME') or define('SITE_NAME', 'CABELTREE');

function loadConfig($prefix, $dir, $extraConfig = []) {
    $fileList = \yii\helpers\FileHelper::findFiles($dir, ['only' => ['*' . $prefix . '.php']]);
    $config = $extraConfig;

    if (!empty($fileList)) {
        $i = 0;
        foreach ($fileList as $filename) {
            $result = require($filename);
            foreach ($result as $key => $values) {
                if (\yii\helpers\ArrayHelper::keyExists($key, $config)) {
                    $config[$key] = \yii\helpers\ArrayHelper::merge($values, $config[$key]);
                } else {
                    $config[$key] = $values;
                }
            }

            $i++;
        }
    }
    return $config;
}
