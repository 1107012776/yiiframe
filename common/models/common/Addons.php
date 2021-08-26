<?php

namespace common\models\common;

use Yii;
use common\models\base\BaseModel;
use common\enums\StatusEnum;
use addons\Wechat\common\models\Rule;
use addons\Wechat\common\models\RuleKeyword;

/**
 * This is the model class for table "{{%common_addons}}".
 *
 * @property int $id 主键
 * @property string $title 中文名
 * @property string $name 插件名或标识
 * @property string $title_initial 首字母拼音
 * @property string $bootstrap 启用文件
 * @property string $service 服务调用类
 * @property string $cover 封面
 * @property string $group 组别
 * @property string $brief_introduction 简单介绍
 * @property string $description 插件描述
 * @property string $author 作者
 * @property string $version 版本号
 * @property array $wechat_message 接收微信回复类别
 * @property int $is_setting 设置
 * @property int $is_rule 是否要嵌入规则
 * @property array $default_config 默认配置
 * @property array $console 控制台
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 */
class Addons extends BaseModel
{
    const TYPE_DEFAULT = 'default'; // 系统菜单
    const TYPE_ADDONS = 'addons'; // 插件菜单

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%common_addons}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'unique', 'message' => '模块名已经占用'],
            [['name', 'title', 'group', 'version', 'author'], 'required'],
            ['name', 'match', 'pattern' => '/^[_a-zA-Z]+$/', 'message' => '标识由英文和下划线组成'],
            [
                ['is_setting', 'is_merchant_route_map', 'is_rule', 'status', 'created_at', 'updated_at'],
                'integer',
            ],
            [['title', 'group', 'version','icon'], 'string', 'max' => 32],
            [['name', 'author'], 'string', 'max' => 40],
            [['title_initial'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 1000],
            [['wechat_message', 'default_config', 'console'], 'safe'],
            [['brief_introduction'], 'string', 'max' => 140],
            [['cover', 'bootstrap', 'service'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'merchant_id' => Yii::t('app', '企业'),
            'title' => Yii::t('app', '标题'),
            'name' => Yii::t('app', '插件名称'),
            'icon' => Yii::t('app', '图标'),
            'title_initial' => Yii::t('app', '拼音'),
            'bootstrap' => Yii::t('app', '启动'),
            'service' => Yii::t('app', '服务调用类'),
            'cover' => Yii::t('app', '封面'),
            'group' => Yii::t('app', '组别'),
            'brief_introduction' => Yii::t('app', '简介'),
            'description' => Yii::t('app', '详细说明'),
            'author' => Yii::t('app', '作者'),
            'version' => Yii::t('app', '版本'),
            'wechat_message' => Yii::t('app', '微信消息'),
            'is_setting' => Yii::t('app', '全局设置'),
            'is_rule' => Yii::t('app', '嵌入规则'),
            'is_merchant_route_map' => Yii::t('app', '企业映射'),
            'default_config' => Yii::t('app', '默认'),
            'console' => Yii::t('app', '控制台'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * 关联绑定的菜单
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBindingMenu()
    {
        return $this->hasMany(AddonsBinding::class,
            ['addons_name' => 'name'])->where(['entry' => 'menu'])->orderBy('id asc');
    }

    /**
     * 关联绑定的入口
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBindingCover()
    {
        return $this->hasMany(AddonsBinding::class,
            ['addons_name' => 'name'])->where(['entry' => 'cover'])->orderBy('id asc');
    }

    /**
     * 关联绑定的菜单和导航
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBinding()
    {
        return $this->hasMany(AddonsBinding::class, ['addons_name' => 'name'])->orderBy('id asc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfig()
    {
        return $this->hasOne(AddonsConfig::class, ['addons_name' => 'name']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 写入缓存数据
        Yii::$app->services->addons->updateCacheByName($this->name);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 卸载插件的时候清理安装的信息
     */
    public function afterDelete()
    {
        // 移除绑定的菜单导航
        AddonsBinding::deleteAll(['addons_name' => $this->name]);
        AddonsConfig::deleteAll(['addons_name' => $this->name]);
        // 卸载权限
        Yii::$app->services->rbacAuthItem->delByAddonsName($this->name);
        // 卸载菜单分类
        Yii::$app->services->menuCate->delByAddonsName($this->name);
        // 卸载菜单
        Yii::$app->services->menu->delByAddonsName($this->name);

        // 移除关键字
//        try {
//            if ($replys = Rule::find()->where([
//                'module' => Rule::RULE_MODULE_ADDON,
//                'data' => $this->name,
//            ])->asArray()->all()) {
//                $ruleIds = array_column($replys, 'rule_id');
//                Rule::deleteAll(['in', 'id', $ruleIds]);
//                RuleKeyword::deleteAll(['in', 'rule_id', $ruleIds]);
//            }
//        } catch (\Exception $exception) {
//
//        }

        // 写入缓存数据
        Yii::$app->services->addons->updateCacheByName($this->name);

        parent::afterDelete();
    }
}
