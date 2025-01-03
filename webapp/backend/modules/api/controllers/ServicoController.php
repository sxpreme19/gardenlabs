<?php

namespace backend\modules\api\controllers;

use common\models\Servico;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;

class ServicoController extends ActiveController
{
    public $modelClass = 'common\models\Servico';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionCount()
    {
        $servicosmodel = new $this->modelClass;
        $recs = $servicosmodel::find()->all();
        return ['count' => count($recs)];
    }

    public function actionFilter($minPrice, $maxPrice, $minDuration, $maxDuration)
    {
        $query = Servico::find();

        if ($minPrice !== null && $maxPrice !== null) {
            $query->andWhere(['>=', 'preco', $minPrice]);
            $query->andWhere(['<=', 'preco', $maxPrice]);
        }

        if ($minDuration !== null && $maxDuration !== null) {
            $query->andWhere(['>=', 'duracao', $minDuration]);
            $query->andWhere(['<=', 'duracao', $maxDuration]);
        }

        $servicos = $query->all();

        return $servicos;
    }
}
