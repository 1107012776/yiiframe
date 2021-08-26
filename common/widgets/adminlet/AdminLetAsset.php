<?php

namespace common\widgets\adminlet;

use yii\web\AssetBundle;

/**
 * Class AdminLetAsset
 * @package common\widgets\adminlet
 * @author YiiFrame <21931118@qq.com>
 */
class AdminLetAsset extends AssetBundle
{
    public $css = [
        'dist/css/skins/_all-skins.min.css',
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/bootstrap-table/bootstrap-table.min.css',
        'bower_components/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
    ];

    public $js = [
        'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'bower_components/bootstrap-table/bootstrap-table.js',
        'bower_components/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js',
        'bower_components/fastclick/lib/fastclick.js',
        'dist/js/adminlte.js',
        'dist/js/demo.js',
    ];

    public $depends = [
        CompatibilityIEAsset::class,
        HeadJsAsset::class,
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/resources';
        parent::init();
    }
}