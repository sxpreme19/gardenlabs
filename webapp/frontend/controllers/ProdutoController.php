<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Produto;
use frontend\models\ProdutoSearch;
use common\models\Favorito;
use common\models\Review;
use frontend\models\ReviewForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


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
                    'only' => ['index', 'product-details', 'delete-review', 'gallery','search'],
                    'rules' => [
                        [
                            'actions' => ['index', 'product-details', 'delete-review', 'gallery','search'],
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
    public function actionIndex($sort = null, $categoria_id = null, $minPrice = null, $maxPrice = null,$search = null)
    {
        $searchModel = new ProdutoSearch();
        $queryParams = $this->request->queryParams;

        if ($search !== null) {
            $queryParams['search'] = $search;
        }

        if ($categoria_id !== null) {
            $queryParams['categoria_id'] = $categoria_id;
        }

        if ($minPrice !== null) {
            $queryParams['minPrice'] = $minPrice;
        }

        if ($maxPrice !== null) {
            $queryParams['maxPrice'] = $maxPrice;
        }

        if (isset($queryParams['sort'])) {
            $queryParams['sort'] = $sort;
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
                ->groupBy(['produto.id'])
                ->count();
        }

        if (isset(Yii::$app->user->identity->userProfile)) {
            $userProfile = Yii::$app->user->identity->userProfile;
            $userWishlist = Favorito::find()->where(['userprofile_id' => $userProfile->user_id,])->with('produto')->all();
            $userWishlistIds = ArrayHelper::getColumn($userWishlist, 'produto_id');
        } else {
            $userWishlistIds = null;
        }


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
            'queryParams' => $queryParams
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

        $reviews = $product->reviews;
        $rating = count($reviews) > 0 ? array_sum(array_column($reviews, 'avaliacao')) / count($reviews) : 0;

        if (!Yii::$app->user->isGuest) {
            $model = new ReviewForm();
            $model->produto_id = $id;
            $model->userprofile_id = Yii::$app->user->identity->userProfile->id;
            if ($model->load(Yii::$app->request->post())) {
                if (isset(Yii::$app->user->identity->userProfile->nome)) {
                    if ($model->validate() && $model->saveReview()) {
                        Yii::$app->session->setFlash('success', 'Your review has been submitted.');
                        return $this->refresh();
                    } else {
                        Yii::$app->session->setFlash('error', 'There was an error submitting your review.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'You need to have a profile name to submit a review.');
                }
            }
        }


        $this->view->title = $product->nome;
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Shop', 'url' => ['produto/index']],
            ['label' => $product->nome],
        ];

        return $this->render('product-details', [
            'product' => $product,
            'productImages' => $productImages,
            'reviews' => $reviews,
            'rating' => $rating,
            'model' => isset($model) ? $model : null,
        ]);
    }

    public function actionDeleteReview($id)
    {
        $review = Review::findOne($id);

        // Check if the review exists and belongs to the current user
        if (!$review || $review->userprofile_id != Yii::$app->user->identity->userProfile->id) {
            Yii::$app->session->setFlash('error', 'You are not allowed to delete this review.');
            return $this->redirect(['product-details', 'id' => $review->produto_id]);
        }

        if ($review->delete()) {
            Yii::$app->session->setFlash('success', 'Your review has been deleted.');
        } else {
            Yii::$app->session->setFlash('error', 'There was an error deleting your review.');
        }

        return $this->redirect(['product-details', 'id' => $review->produto_id]);
    }


    /**
     * Displays the Produto gallery.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGallery()
    {
        $products = Produto::find()->joinWith('imagems')->where(['not', ['imagem.id' => null]])->all();

        $categories = Categoria::find()->all();
        $productTotalCount = Produto::find()->joinWith('imagems')->where(['not', ['imagem.id' => null]])->distinct()->count();

        if (isset(Yii::$app->user->identity->userProfile)) {
            $userProfile = Yii::$app->user->identity->userProfile;
            $userWishlist = Favorito::find()->where(['userprofile_id' => $userProfile->user_id,])->with('produto')->all();
            $userWishlistIds = ArrayHelper::getColumn($userWishlist, 'produto_id');
        } else {
            $userWishlistIds = null;
        }

        $this->view->title = 'Gallery';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => 'Gallery'],
        ];

        return $this->render('gallery', [
            'products' => $products,
            'categories' => $categories,
            'productTotalCount' => $productTotalCount,
            'userWishlistIds' => $userWishlistIds,
        ]);
    }

    public function actionSearch($q)
    {
        $products = Produto::find()->joinWith('imagems')->where(['not', ['imagem.id' => null]])->andWhere(['>', 'produto.quantidade', 0])->andWhere(['like', 'nome', $q])->all();
        $result = [];
        foreach ($products as $product) {
            $firstImage = null;
            if (!empty($product->imagems)) {
                $firstImage = $product->imagems[0];
            }
            $result[] = [
                'nome' => $product->nome,
                'url' => Url::to(['produto/product-details', 'id' => $product->id]),
                'image_url' => $firstImage ? Url::to('../../backend/web/uploads/' . $firstImage->filename) : Url::to('@web/images/no-image-available.png'),
            ];
        }

        return $this->asJson($result);
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
