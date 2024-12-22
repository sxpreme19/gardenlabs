<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Favorito;


/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
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
                    'only' => ['index', 'add-to-wishlist','delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'add-to-wishlist','delete'],
                            'allow' => true,
                            'roles' => ['client'],
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
            ]
        );
    }

    /**
     * Displays wishlist page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $userWishlist = Favorito::find()->where(['userprofile_id' => $userProfile->user_id,])->with('produto')->all();

        $this->view->title = 'Wishlist';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];
        return $this->render('index', ['userWishlist' => $userWishlist]);
    }

    /**
     * Adds product to the users wishlist.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAddToWishlist($productId)
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $wishlistItem = new Favorito();
        $wishlistItem->userprofile_id = $userProfile->user_id;
        $wishlistItem->produto_id = $productId;
        $existingWishlistItem = Favorito::find()->where(['userprofile_id' => $userProfile->user_id, 'produto_id' => $productId])->one();
        if (!$existingWishlistItem) {
            $wishlistItem->save();
            Yii::$app->session->setFlash('success', 'Product added to your wishlist.');
        } else {
            Yii::$app->session->setFlash('info', 'This product is already in your wishlist.');
        }
        return $this->redirect(['produto/index']);
    }

    /**
     * Removes wishlist item.
     *
     * @return mixed
     */
    public function actionDelete($productId)
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $userWishlistItemtoRemove = Favorito::findOne([
            'produto_id' => $productId,
            'userprofile_id' => $userProfile->user_id,
        ]);

        if (!$userWishlistItemtoRemove) {
            Yii::$app->session->setFlash('error', 'Item not found in wishlist.');
            return $this->redirect(['index']);
        }

        if ($userWishlistItemtoRemove->delete()) {
            Yii::$app->session->setFlash('success', 'Item removed from wishlist successfully.');
            return $this->render('index');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to remove item from wishlist.');
            return $this->redirect(['index']);
        }
    }
}
