<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@services', dirname(dirname(__DIR__)) . '/services');
Yii::setAlias('@addons', dirname(dirname(__DIR__)) . '/addons');
Yii::setAlias('@attachment', dirname(dirname(__DIR__)) . '/backend/web/attachment'); // 本地资源目录绝对路径
Yii::setAlias('@attachurl', '/attachment'); // 资源目前相对路径，可以带独立域名，例如 https://attachment.yiiframe.com
Yii::setAlias('@root', dirname(dirname(__DIR__)) . '/');
