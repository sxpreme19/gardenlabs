<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Produto;
use common\models\ProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

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
                'only' => ['index','product-details','gallery'],
                'rules' => [
                    [
                        'actions' => ['index','product-details','gallery'],
                        'allow' => true,
                        'roles' => ['?','client'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action){
                            return Yii::$app->user->can('accessBackend');
                        }
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'], 
                    ],
                ],
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
    public function actionIndex($categoria_id = null)
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        if($categoria_id != null){
            $products = Produto::find()
            ->joinWith('imagems') 
            ->where(['not', ['imagem.id' => null]])
            ->andWhere(['categoria_id' => $categoria_id]) 
            ->all();
        }else{
            $products = Produto::find()
            ->joinWith('imagems') 
            ->where(['not', ['imagem.id' => null]]) 
            ->all();
        }
        
        $productDisplayCount = count($products);
        $categories = Categoria::find()->all();
        $productsPerCategory = [];
        foreach($categories as $category){
            $productsPerCategory[$category->id] = count(Produto::find()->where(['categoria_id' => $category->id])->all());
        }

        $this->view->title = 'Product Shop';
        $this->view->params['breadcrumbs'] = [
        ['label' => 'Home', 'url' => ['site/index']],
        ['label' => $this->view->title],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'products' => $products,
            'productDisplayCount' => $productDisplayCount,
            'categories' => $categories,
            'productsPerCategory' => $productsPerCategory,
        ]);
    }

    /**
     * Displays a single Produto model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProductDetails($id)
    {
        $product = Produto::findOne($id);
        $productImages = $product->imagems;

        $this->view->title = $product->nome;
        $this->view->params['breadcrumbs'] = [
        ['label' => 'Shop', 'url' => ['site/shop']],
        //['label' => 'Category Name', 'url' => ['site/', 'id' => $product->categoria_id]],
        ['label' => $product->nome],
        ];
        
        return $this->render('product-details', [
            'product' => $product,
            'productImages' => $productImages,
        ]);
    }

    /**
     * Displays the Produto gallery.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGallery()
    {
        $products = Produto::find()
            ->joinWith('imagems') 
            ->where(['not', ['imagem.id' => null]]) 
            ->all();
        $categories = Categoria::find()->all();

        $this->view->title = 'Gallery';
        $this->view->params['breadcrumbs'] = [
        ['label' => 'Home', 'url' => ['site/index']],
        //['label' => 'Category Name', 'url' => ['site/', 'id' => $product->categoria_id]],
        ['label' => 'Gallery'],
        ];
        
        return $this->render('gallery', [
            'products' => $products,
            'categories' => $categories,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
