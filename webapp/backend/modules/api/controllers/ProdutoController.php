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
class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

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
        $produtosmodel = new $this->modelClass;
        $recs = $produtosmodel::find()->all();
        return ['count' => count($recs)];
    }
    public function actionNomes()
    {
        $produtosmodel = new $this->modelClass;
        $recs = $produtosmodel::find()->select(['nome'])->all();
        return $recs;
    }

    public function actionPreco($id)
    {
        $produtosmodel = new $this->modelClass;
        $recs = $produtosmodel::find()->select(['preco'])->where(['id' => $id])->one();
        return $recs;
    }

    public function actionPrecopornome($nomeproduto){
        $produtosmodel = new $this->modelClass;
        $recs = $produtosmodel::find()->select(['preco'])->where(['nome' => $nomeproduto])->all();
        return $recs;
    }

    public function actionDelpornome($nomeproduto){
        $produtosmodel = new $this->modelClass;
        $recs = $produtosmodel::deleteAll(['nome' => $nomeproduto]);
         return $recs;
    }

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

    public function actionPostpratovazio(){
        $pratomodel = new $this->modelClass;
        $pratomodel->id = 0;
        $pratomodel->titulo = '';
        $pratomodel->descricao = '';
        $pratomodel->preco = 0;
        $pratomodel->disponivel = 0;
        $pratomodel->save();
        return $pratomodel;
    }

    public function actionData_criacao($data_criacao){
        $pratosmodel = new $this->modelClass;
        $recs = $pratosmodel->find()->where(['>=' , 'data_criacao' , $data_criacao])->all();
        return $recs;
    }
}