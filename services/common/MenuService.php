<?php

namespace services\common;

use common\enums\AppEnum;
use Yii;
use yii\helpers\Json;
use common\models\common\MenuCate;
use common\helpers\ArrayHelper;
use common\components\Service;
use common\models\common\Menu;
use common\enums\StatusEnum;
use common\enums\WhetherEnum;
use common\helpers\StringHelper;
use common\helpers\Auth;
use common\helpers\TreeHelper;

/**
 * Class MenuService
 * @package services\sys
 * @author YiiFrame <21931118@qq.com>
 */
class MenuService extends Service
{
    /**
     * @param string $addons_name 插件名称
     */
    public function delByAddonsName($addons_name)
    {
        Menu::deleteAll(['addons_name' => $addons_name]);
    }

    /**
     * @param MenuCate $cate
     */
    public function delByCate(MenuCate $cate)
    {
        Menu::deleteAll(['app_id' => $cate->app_id, 'addons_name' => $cate->addons_name]);
    }

    /**
     * @param array $menus
     * @param MenuCate $cate
     * @param int $pid
     * @param int $level
     * @param Menu $parent
     */
    public function createByAddons(array $menus, MenuCate $cate, $pid = 0, $level = 1, $parent = '')
    {
        // 重组数组
        $menus = ArrayHelper::regroupMapToArr($menus);

        foreach ($menus as $menu) {
            $model = new Menu();
            $model->attributes = $menu;
            // 增加父级
            !empty($parent) && $model->setParent($parent);

            if ($model->params) {
                $params = [];
                foreach ($model->params as $key => $value) {
                    $params[] = [
                        'key' => $key,
                        'value' => $value,
                    ];
                }

                $model->params = $params;
            }

            $model->url = '/' . StringHelper::toUnderScore($cate->addons_name) . '/' . $menu['route'];
            $model->pid = $pid;
            $model->level = $level;
            $model->cate_id = $cate->id;
            $model->app_id = $cate->app_id;
            $model->addons_name = $cate->addons_name;
            $model->is_addon = $cate->is_addon;
            $model->save();

            if (isset($menu['child']) && !empty($menu['child'])) {
                $this->createByAddons($menu['child'], $cate, $model->id, $model->level + 1, $model);
            }
        }
    }

    /**
     * 获取下拉
     *
     * @param MenuCate $menuCate
     * @param string $id
     * @return array
     */
    public function getDropDown(MenuCate $menuCate, $app_id, $id = '')
    {
        $list = Menu::find()
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['app_id' => $app_id])
            ->andWhere(['is_addon' => $menuCate->is_addon])
            ->andFilterWhere(['addons_name' => $menuCate->addons_name])
            ->andFilterWhere(['<>', 'id', $id])
            ->select(['id', 'title', 'pid', 'level'])
            ->orderBy('cate_id asc, sort asc')
            ->asArray()
            ->all();

        $models = ArrayHelper::itemsMerge($list);
        $data = ArrayHelper::map(ArrayHelper::itemsMergeDropDown($models), 'id', 'title');

        return ArrayHelper::merge([0 => Yii::t('app','Top menu')], $data);
    }

    /**
     * @return array
     */
    public function getOnAuthList()
    {
        $models = $this->findAll();

        // 获取权限信息
        foreach ($models as $key => &$model) {
            if (!empty($model['url'])) {
                $params = Json::decode($model['params']);
                (empty($params) || !is_array($params)) && $params = [];
                $model['fullUrl'][] = $model['url'];

                foreach ($params as $param) {
                    if (!empty($param['key'])) {
                        $model['fullUrl'][$param['key']] = $param['value'];
                    }
                }
            } else {
                $model['fullUrl'] = '#';
            }

            // 系统菜单校验
            if ($model['is_addon'] == WhetherEnum::DISABLED && Auth::verify($model['url']) === false) {
                unset($models[$key]);
            }

            // 插件菜单校验
            if ($model['is_addon'] == WhetherEnum::ENABLED) {
                if (Auth::verify($model['url']) === false) {
                    unset($models[$key]);
                }

                unset($tmpUrl);
            }
        }

        return ArrayHelper::itemsMerge($models);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findAll()
    {
        $data = Menu::find()->where(['status' => StatusEnum::ENABLED]);
        // 关闭开发模式
        if (!Yii::$app->debris->backendConfig('sys_dev')) {
            $data = $data->andWhere(['dev' => StatusEnum::DISABLED]);
        }

        $models = $data->andWhere(['app_id' => Yii::$app->id])
            ->with(['cate' => function (\yii\db\ActiveQuery $query) {
                return $query->andWhere(['app_id' => Yii::$app->id]);
            }])
            ->orderBy('sort asc, id asc')
            ->asArray()
            ->all();
            foreach ($models as $key => $model) {//审批管理菜单下显示已安装的工作流
                if (strstr($model['url'], '/office/approve/')) {
                    $workflow_id = \common\helpers\StringHelper::cut('/office/approve/', '/index', $model['url']);
                    $workflow = \addons\Office\common\models\Workflow::find()->where(['merchant_id' => Yii::$app->user->identity->merchant_id, 'id' => $workflow_id])->one();
                    if (!$workflow) unset($models[$key]);
                }
            }
        return $models;
    }

    /**
     * @param $tree
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findChildByID($tree, $id)
    {
        return Menu::find()
            ->where(['like', 'tree', $tree . TreeHelper::prefixTreeKey($id) . '%', false])
            ->select(['id', 'level', 'tree', 'pid'])
            ->asArray()
            ->all();
    }
}