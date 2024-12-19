<?php

namespace backend\modules\api\controllers;

use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class ServicoController extends ActiveController
{
    public $modelClass = 'common\models\Servico';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => [$this,'auth']
        ];
        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'], 
                ],
            ],
        ];
        
        return $behaviors;
    }

    public function auth($username,$password){
        $user = User::findByUsername($username);
        if($user && $user->validatePassword($password)){
            return $user;
        }
        throw new ForbiddenHttpException('No authentication');
    }

    public function actionCount()
    {
        $servicosmodel = new $this->modelClass;
        $recs = $servicosmodel::find()->all();
        return ['count' => count($recs)];
    }
    public function actionNomes()
    {
        $servicosmodel = new $this->modelClass;
        $recs = $servicosmodel::find()->select(['titulo'])->all();
        return $recs;
    }

    public function actionPreco($id)
    {
        $servicosmodel = new $this->modelClass;
        $recs = $servicosmodel::find()->select(['preco'])->where(['id' => $id])->one();
        return $recs;
    }

    public function actionPrecopornome($tituloservico){
        $servicosmodel = new $this->modelClass;
        $recs = $servicosmodel::find()->select(['preco'])->where(['titulo' => $tituloservico])->all();
        return $recs;
    }

    public function actionDelpornome($nomeproduto){
        $servicosmodel = new $this->modelClass;
        $recs = $servicosmodel::deleteAll(['nome' => $nomeproduto]);
         return $recs;
    }
    /*
    public function actionPutprecopornome($nomeprato){
        $novo_preco = \Yii::$app->request->post('preco');
        $pratosmodel = new $this->modelClass;
        $ret = $pratosmodel::findOne(['titulo' => $nomeprato]);
        if($ret){
            $ret->preco = $novo_preco;
            $ret->save();
        }else{
            throw new \yii\web\NotFoundHttpException("Nome de prato não existe");
        }
    }

    
    public function actionPostprodutovazio(){
        $produtomodel = new $this->modelClass;
        $produtomodel->nome = null;
        $produtomodel->descricao = null;
        $produtomodel->preco = null;
        $produtomodel->quantidade = 0;
        $produtomodel->fornecedor_id = null;
        $produtomodel->categoria_id = null;
        $produtomodel->save();
        return $produtomodel;
    }

    public function actionData_criacao($data_criacao){
        $pratosmodel = new $this->modelClass;
        $recs = $pratosmodel->find()->where(['>=' , 'data_criacao' , $data_criacao])->all();
        return $recs;
    }*/
}