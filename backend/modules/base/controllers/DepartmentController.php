<?php

namespace backend\modules\base\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\traits\Curd;
use common\models\backend\Department;
use backend\controllers\BaseController;

/**
 * 企业分类
 *
 * Class CateController
 * @package addons\Merchants\backend\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class DepartmentController extends BaseController
{
    use Curd;

    /**
     * @var Cate
     */
    public $modelClass = Department::class;

    /**
     * Lists all Tree models.
     * @return mixed
     */
    public function actionIndex()
    {
//        var_dump($this->getMerchantId());
        $query = $this->modelClass::find()
            ->andWhere(['merchant_id' => $this->getMerchantId()])
            ->orderBy('sort asc, created_at asc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed|string|\yii\console\Response|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionAjaxEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = $this->findModel($id);
        $model->pid = $request->get('pid', null) ?? $model->pid; // 父id
        $model->merchant_id = Yii::$app->user->identity->merchant_id;

        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            return $model->save()
                ? $this->redirect(['index'])
                : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'dropDown' => Yii::$app->services->backendDepartment->getDropDownForEdit(),
        ]);
    }

}