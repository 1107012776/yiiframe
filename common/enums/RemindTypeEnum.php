<?php

namespace common\enums;

use common\enums\BaseEnum;
/**
 * 枚举
 *
 * Class GenderEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class RemindTypeEnum extends BaseEnum
{
    const sms = 2;
    const message = 1;
    const normal = 0;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::sms => \Yii::t('app','SMS'),
            self::message => \Yii::t('app','Message'),
            self::normal => \Yii::t('app','No remind'),

        ];
    }

    public static function getValue($key): string
    {
        return static::getMap()[$key] ?? '';
    }
}