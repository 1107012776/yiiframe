<?php

namespace common\models\common;

use Yii;
use common\enums\WhetherEnum;
use common\helpers\TreeHelper;
use common\enums\StatusEnum;

/**
 * This is the model class for table "rf_common_menu_cate".
 *
 * @property int $id 主键
 * @property string $title 标题
 * @property string $app_id 应用
 * @property string $addons_name 插件名称
 * @property string $icon icon
 * @property int $is_default_show 默认显示
 * @property int $is_addon 默认非插件顶级分类
 * @property int $sort 排序
 * @property int $level 级别
 * @property int $addon_centre
 * @property string $tree 树
 * @property string $pid 上级id
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property string $created_at 添加时间
 * @property string $updated_at 修改时间
 */
class MenuCate extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%common_menu_cate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['level', 'pid', 'addon_centre', 'is_default_show', 'is_addon', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['app_id', 'icon'], 'string', 'max' => 20],
            [['addons_name'], 'string', 'max' => 100],
            [['tree'], 'string', 'max' => 300],
            [['level'], 'default', 'value' => 1],
            [['title', 'icon'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '标题'),
            'app_id' => Yii::t('app', '应用'),
            'addons_name' => Yii::t('app', '插件名称'),
            'icon' => Yii::t('app', '图标'),
            'is_default_show' => Yii::t('app', '显示'),
            'is_addon' => Yii::t('app', '插件'),
            'sort' => Yii::t('app', '排序'),
            'level' => Yii::t('app', '级别'),
            'pid' => Yii::t('app', '父级'),
            'tree' => Yii::t('app', '树'),
            'addon_centre' => Yii::t('app', '应用中心'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->is_default_show == StatusEnum::ENABLED) {
            self::updateAll(['is_default_show' => StatusEnum::DISABLED], ['is_default_show' => StatusEnum::ENABLED, 'app_id' => $this->app_id]);
        }

        if ($this->isNewRecord) {
            !$this->app_id && $this->app_id = Yii::$app->id;
            !$this->is_addon && $this->is_addon = WhetherEnum::DISABLED;
            $this->pid == 0 && $this->tree = TreeHelper::defaultTreeKey();
        }

        return parent::beforeSave($insert);
    }
}