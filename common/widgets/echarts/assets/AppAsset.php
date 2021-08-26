<?php

namespace common\widgets\echarts\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package common\widgets\echarts\assets
 * @author YiiFrame <21931118@qq.com>
 */
class AppAsset extends AssetBundle
{

    public $sourcePath = '@common/widgets/echarts/resources/';

    public $css = [
    ];

    public $js = [
        'echarts.min.js',
        'extension/bmap.js',
        'extension/echarts-wordcloud.min.js',
        'theme/macarons.js',
        'theme/purple-passion.js',
        'theme/roma.js',
        'theme/walden.js',
        'theme/westeros.js',
        'theme/wonderland.js',
    ];
}