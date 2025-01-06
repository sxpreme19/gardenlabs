<?php

namespace backend\modules\api\controllers;

use common\models\Linhacarrinhoservico;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;

/**
 * Default controller for the `api` module
 */
class LinhacarrinhoservicoController extends ActiveController
{
    public $modelClass = 'common\models\Linhacarrinhoservico';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionAddtocart()
    {
        $request = \Yii::$app->request;
        $model = new Linhacarrinhoservico();
        $model->load($request->post(), '');

        if ($model->save()) {
            $cart = $model->carrinhoservico;
            $cart->calculateTotal();

            return $model; 
        }

        return [
            'status' => 'error',
            'message' => 'Failed to add to cart',
            'errors' => $model->errors,
        ];
    }


    public function actionGetbycarrinhoservicoid($id)
    {
        $serviceCartLines = Linhacarrinhoservico::find()
            ->where(['carrinhoservico_id' => $id])
            ->all();

        return $serviceCartLines;
    }

    public function actionRemovefromcart($id)
    {
        $lineId = $id;
        $model = Linhacarrinhoservico::findOne($lineId);

        if (!$model) {
            return [
                'status' => 'error',
                'message' => 'Cart line not found',
            ];
        }

        $cart = $model->carrinhoservico;

        if ($model->delete()) {
            $cart->calculateTotal();

            return [
                'status' => 'success',
                'message' => 'Removed from cart successfully',
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Failed to remove from cart',
        ];
    }
}
