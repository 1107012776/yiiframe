<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-cn',
    'timeZone' => 'Asia/Shanghai',
    'bootstrap' => [
        'common\components\Init', // 加载默认的配置
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@backend/runtime/cache'
        ],
        /** ------ 网站碎片管理 ------ **/
        'debris' => [
            'class' => 'common\components\Debris',
        ],
        /** ------ 格式化时间 ------ **/
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        /** ------ 服务层 ------ **/
        'services' => [
            'class' => 'services\Application',
        ],
        /** ------ 多语言 ------ **/
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'addon' => 'addon.php',
                    ],
                ],
            ],
        ],
    ],
];
