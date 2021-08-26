<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\traits\BaseAction;
use common\helpers\Auth;
use yii\web\NotFoundHttpException;
/**
 * Class BaseController
 * @package backend\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class BaseController extends Controller
{
    use BaseAction;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // 登录
                    ],
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        // 每页数量
        $this->pageSize = Yii::$app->request->get('per-page', 20);
        $this->pageSize > 50 && $this->pageSize = 50;

        // 判断当前模块的是否为主模块, 模块+控制器+方法
        $permissionName = '/' . Yii::$app->controller->route;
        // 判断是否忽略校验
        if (in_array($permissionName, Yii::$app->params['noAuthRoute'])) {
            return true;
        }
        // 开始权限校验
        if (!Auth::verify($permissionName)) {
            throw new ForbiddenHttpException('对不起，您现在还没获此操作的权限');
        }

        // 记录上一页跳转
        $this->setReferrer($action->id);

        return true;
    }
}