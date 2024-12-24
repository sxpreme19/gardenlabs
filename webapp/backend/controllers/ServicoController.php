<?php

namespace backend\controllers;

use common\models\Servico;
use backend\models\ServicoSearch;
use common\models\Carrinhoservico;
use common\models\Linhacarrinhoservico;
use common\models\Linhafatura;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServicoController implements the CRUD actions for Servico model.
 */
class ServicoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Servico models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServicoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Servico model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Servico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Servico();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Servico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $userCartLines = Linhacarrinhoservico::findAll(['servico_id' => $model->id]);

            foreach ($userCartLines as $line) {
                $line->preco = $model->preco;
                $line->save();
                $userCart = Carrinhoservico::findOne($line->carrinhoservico_id);
                if ($userCart) {
                    $userCart->total = $userCart->calculateTotal();
                    $userCart->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Servico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $hasInvoices = Linhafatura::find()->where(['servico_id' => $id])->exists();
        if ($hasInvoices) {
            Yii::$app->session->setFlash('error', 'This product cannot be deleted because it is associated with invoices.');
            return $this->redirect(['index']);
        }

        $userCartLines = Linhacarrinhoservico::findAll(['servico_id' => $id]);
        $affectedCarts = [];

        foreach ($userCartLines as $line) {
            $cartId = $line->carrinhoproduto_id;
            if (!in_array($cartId, $affectedCarts)) {
                $affectedCarts[] = $cartId;
            }
            $line->delete();
        }

        foreach ($affectedCarts as $cartId) {
            $cart = Carrinhoservico::findOne($cartId);
            if ($cart) {
                $cart->calculateTotal();
            }
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Servico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Servico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Servico::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
