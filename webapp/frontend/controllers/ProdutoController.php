<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Produto;
use frontend\models\ProdutoSearch;
use common\models\Favorito;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\ArrayHelper;

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
                    'only' => ['index', 'product-details', 'gallery'],
                    'rules' => [
                        [
                            'actions' => ['index', 'product-details', 'gallery'],
                            'allow' => true,
                            'roles' => ['?', 'client'],
                        ],
                        [
                            'allow' => false,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
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
    public function actionIndex($categoria_id = null, $minPrice = null, $maxPrice = null)
    {
        $searchModel = new ProdutoSearch();
        $queryParams = $this->request->queryParams;

        if ($categoria_id !== null) {
            $queryParams['categoria_id'] = $categoria_id;
        }

        if ($minPrice !== null) {
            $queryParams['minPrice'] = $minPrice;
        }

        if ($maxPrice !== null) {
            $queryParams['maxPrice'] = $maxPrice;
        }

        $dataProvider = $searchModel->search($queryParams);
        $productDisplayCount = $dataProvider->getTotalCount();
        $categories = Categoria::find()->all();

        $productsPerCategory = [];
        foreach ($categories as $category) {
            $productsPerCategory[$category->id] = Produto::find()
                ->joinWith('imagems')
                ->where(['not', ['imagem.id' => null]])
                ->andWhere(['categoria_id' => $category->id])
                ->andWhere(['>', 'quantidade', 0])
                ->groupBy(['produto.id'])
                ->count();
        }

        $userProfile = Yii::$app->user->identity->userProfile;
        $userWishlist = Favorito::find()->where(['userprofile_id' => $userProfile->user_id,])->with('produto')->all();
        $userWishlistIds = ArrayHelper::getColumn($userWishlist, 'produto_id'); 


        $this->view->title = 'Product Shop';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'productDisplayCount' => $productDisplayCount,
            'categories' => $categories,
            'productsPerCategory' => $productsPerCategory,
            'userWishlistIds' => $userWishlistIds,
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
            ['label' => 'Shop', 'url' => ['produto/index']],
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
        $productTotalCount = Produto::find()->count();

        $this->view->title = 'Gallery';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => 'Gallery'],
        ];

        return $this->render('gallery', [
            'products' => $products,
            'categories' => $categories,
            'productTotalCount' => $productTotalCount,
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
