<?php

namespace backend\controllers;

use common\models\Produto;
use backend\models\ImagemSearch;
use backend\models\ProdutoSearch;
use common\models\Carrinhoproduto;
use common\models\Linhacarrinhoproduto;
use common\models\Linhafatura;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\AccessControl;



/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['index', 'view', 'create', 'update'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page.');
                    },
                ],
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
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produto model.
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
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if ($this->request->post('add_images') === 'yes') {
                    return $this->redirect(['imagem/upload', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('success', "Product created (without image)");
                    return $this->redirect(['index']);
                }
            }
        }

        $this->view->title = 'Create Produto';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Products', 'url' => ['produto/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $userCartLines = Linhacarrinhoproduto::findAll(['produto_id' => $model->id]);

            foreach ($userCartLines as $line) {
                $line->precounitario = $model->preco;
                $line->save();
                $userCart = Carrinhoproduto::findOne($line->carrinhoproduto_id);
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
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $hasInvoices = Linhafatura::find()->where(['product_id' => $id])->exists();
        if ($hasInvoices) {
            Yii::$app->session->setFlash('error', 'This product cannot be deleted because it is associated with invoices.');
            return $this->redirect(['index']);
        }

        $userCartLines = Linhacarrinhoproduto::findAll(['produto_id' => $id]);
        $affectedCarts = [];

        foreach ($userCartLines as $line) {
            $cartId = $line->carrinhoproduto_id;
            if (!in_array($cartId, $affectedCarts)) {
                $affectedCarts[] = $cartId;
            }
            $line->delete();
        }

        foreach ($affectedCarts as $cartId) {
            $cart = Carrinhoproduto::findOne($cartId);
            if ($cart) {
                $cart->calculateTotal();
            }
        }

        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Product deleted successfully.');

        return $this->redirect(['index']);
    }


    /**
     * Managing images of an existing Produto model.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionManageImages($id)
    {
        $searchModel = new ImagemSearch();

        $dataProvider = $searchModel->search([
            'produto_id' => $id,
        ]);

        $this->view->title = 'Manage Images';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Products', 'url' => ['produto/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('manage-images', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'produto_id' => $id,
        ]);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
