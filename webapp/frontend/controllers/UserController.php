<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\UpdateUserForm;
use common\models\Userprofile;
use common\models\Favorito;
use common\models\Metodoexpedicao;
use common\models\Metodopagamento;
use common\models\Linhacarrinhoproduto;
use common\models\Carrinhoproduto;
use common\models\User;
use common\models\Produto;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                    'only' => ['index', 'my-account', 'account-details', 'wishlist', 'add-to-wishlist','remove-wishlist-item', 'cart', 'add-to-cart', 'update-quantity','remove-cart-item', 'checkout','confirm-checkout', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'my-account', 'account-details', 'wishlist', 'add-to-wishlist','remove-wishlist-item', 'cart', 'add-to-cart', 'update-quantity','remove-cart-item', 'checkout','confirm-checkout', 'delete'],
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        $this->view->title = 'My Account';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays My-Account page.
     *
     * @return mixed
     */
    public function actionMyAccount()
    {
        $userProfile = Userprofile::findOne(['user_id' => Yii::$app->user->id]);

        $this->view->title = 'My Account';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];
        return $this->render('my-account', [
            'userProfile' => $userProfile,
        ]);
    }

    /**
     * Displays account-details page.
     *
     * @return mixed
     */
    public function actionAccountDetails()
    {
        $model = new UpdateUserForm();
        $userProfile = Userprofile::findOne(['user_id' => Yii::$app->user->id]);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('success', 'Details have been updated successfully!');
            return $this->goHome();
        }

        $this->view->title = 'Edit Details';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'My Account', 'url' => ['user/my-account']],
            ['label' => $this->view->title],
        ];

        return $this->render('account-details', [
            'model' => $model,
            'userProfile' => $userProfile,
        ]);
    }

    /**
     * Displays wishlist page.
     *
     * @return mixed
     */
    public function actionWishlist()
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $userWishlist = Favorito::find()->where(['userprofile_id' => $userProfile->user_id,])->with('produto')->all();

        $this->view->title = 'Wishlist';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];
        return $this->render('wishlist', ['userWishlist' => $userWishlist]);
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
    public function actionRemoveWishlistItem($wishlistItemId)
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $userWishlistItemtoRemove = Favorito::findOne(['id' => $wishlistItemId]);

        if (!$userWishlistItemtoRemove) {
            Yii::$app->session->setFlash('error', 'Item not found in wishlist.');
            return $this->redirect(['wishlist']);
        }

        if ($userWishlistItemtoRemove->delete()) {
            $userWishlist = Favorito::find()->where(['userprofile_id' => $userProfile->user_id])->with('produto')->all();
            Yii::$app->session->setFlash('success', 'Item removed from wishlist successfully.');
            return $this->render('wishlist', ['userWishlist' => $userWishlist]);
        }else {
            Yii::$app->session->setFlash('error', 'Failed to remove item from wishlist.');
            return $this->redirect(['wishlist']);
        }
    }

    /**
     * Displays cart page.
     *
     * @return mixed
     */
    public function actionCart()
    {
        $userCart = Carrinhoproduto::findOne(['userprofile_id' => Yii::$app->user->identity->userProfile->id]);

        $this->view->title = 'Cart';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('cart', ['userCart' => $userCart]);
    }

    /**
     * Adds product to the user's product cart.
     * @param int $productId ID of the product to add
     * @param int $productQuantity Quantity of the product to add
     * @return \yii\web\Response Redirects to the index page
     * @throws NotFoundHttpException if the product cannot be found
     */
    public function actionAddToCart($productId, $productQuantity)
    {
        $userProfile = Yii::$app->user->identity->userProfile;

        $product = Produto::findOne($productId);
        if (!$product) {
            throw new NotFoundHttpException("Product not found.");
        }

        $userCart = $userProfile->carrinhoproduto;
        if (!$userCart) {
            throw new NotFoundHttpException("Cart not found.");
        }

        $existingCartItem = Linhacarrinhoproduto::find()
            ->where(['carrinhoproduto_id' => $userCart->id, 'produto_id' => $productId])
            ->one();

        if ($existingCartItem) {
            $existingCartItem->quantidade += $productQuantity;
            $existingCartItem->save();

            Yii::$app->session->setFlash('info', 'Product quantity updated in your cart.');
        } else {
            $newCartItem = new Linhacarrinhoproduto();
            $newCartItem->precounitario = $product->preco;
            $newCartItem->quantidade = $productQuantity;
            $newCartItem->carrinhoproduto_id = $userCart->id;
            $newCartItem->produto_id = $productId;
            $newCartItem->save();

            Yii::$app->session->setFlash('success', 'Product added to your cart.');
        }

        $cartTotal = 0;
        foreach ($userCart->linhacarrinhoprodutos as $cartItem) {
            $cartTotal += $cartItem->quantidade * $cartItem->precounitario;
        }
        $userCart->total = $cartTotal;
        $userCart->save();

        return $this->redirect(['produto/index']);
    }

    public function actionUpdateQuantity()
    {
        if (Yii::$app->request->isPost) {
            $itemId = Yii::$app->request->post('itemId');
            $quantity = Yii::$app->request->post('quantity');

            if ($itemId && $quantity && is_numeric($quantity) && $quantity > 0) {
                $cartItem = Linhacarrinhoproduto::findOne($itemId);

                if ($cartItem) {
                    $cartItem->quantidade = $quantity;
                    if ($cartItem->save()) {
                        $userProfile = Yii::$app->user->identity->userProfile;
                        $userCart = $userProfile->carrinhoproduto;
                        $userCart->total = 0;
                        foreach ($userCart->linhacarrinhoprodutos as $item) {
                            $userCart->total += $item->produto->preco * $item->quantidade;
                        }
                        $userCart->save();

                        return $this->redirect(['user/cart']);
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to update cart item');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Cart item not found');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Invalid quantity');
            }
        }

        return $this->redirect(['user/cart']);
    }

    /**
     * Removes cart item.
     *
     * @return mixed
     */
    public function actionRemoveCartItem($cartItemId)
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $userCartItemtoRemove = Linhacarrinhoproduto::findOne(['id' => $cartItemId]);

        if (!$userCartItemtoRemove) {
            Yii::$app->session->setFlash('error', 'Item not found in cart.');
            return $this->redirect(['cart']);
        }

        if ($userCartItemtoRemove->delete()) {
            $userCart = Carrinhoproduto::findOne(['userprofile_id' => $userProfile->id]);
            $userCart->total -= $userCartItemtoRemove->produto->preco * $userCartItemtoRemove->quantidade;
            $userCart->save();
            Yii::$app->session->setFlash('success', 'Item removed from cart successfully.');
            return $this->render('cart', ['userCart' => $userCart]);
        }else {
            Yii::$app->session->setFlash('error', 'Failed to remove item from cart.');
            return $this->redirect(['cart']);
        }
    }

    /**
     * Displays checkout page.
     *
     * @return mixed
     */
    public function actionCheckout()
    {
        $shippingMethods = Metodoexpedicao::find()->all();
        $paymentMethods = Metodopagamento::find()->all();
        $userCart = Carrinhoproduto::findOne(['userprofile_id' => Yii::$app->user->identity->userProfile->id]);
        $userProfile = Yii::$app->user->identity->userProfile;

        $this->view->title = 'Checkout';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Cart', 'url' => ['user/cart']],
            ['label' => $this->view->title],
        ];

        return $this->render('checkout', [
            'shippingMethods' => $shippingMethods,
            'paymentMethods' => $paymentMethods,
            'userCart' => $userCart,
            'userProfile' => $userProfile
        ]);
    }

    /**
     * Displays confirm-checkout page.
     *
     * @return mixed
     */
    public function actionConfirmCheckout($checkoutSelectedPaymentMethod,$checkoutSelectedShippingMethod)
    {
        $shippingMethods = Metodoexpedicao::find()->all();
        $paymentMethods = Metodopagamento::find()->all();
        $selectedPaymentMethod = Metodopagamento::findOne($checkoutSelectedPaymentMethod);
        $selectedShippingMethod = Metodoexpedicao::findOne($checkoutSelectedShippingMethod);
        $userCart = Carrinhoproduto::findOne(['userprofile_id' => Yii::$app->user->identity->userProfile->id]);
        $userProfile = Yii::$app->user->identity->userProfile;

        $this->view->title = 'Confirm Checkout';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Cart', 'url' => ['user/cart']],
            ['label' => $this->view->title],
        ];

        return $this->render('confirm-checkout', [
            'shippingMethods' => $shippingMethods,
            'paymentMethods' => $paymentMethods,
            'userCart' => $userCart,
            'userProfile' => $userProfile,
            'selectedPaymentMethod' => $selectedPaymentMethod,
            'selectedShippingMethod' => $selectedShippingMethod
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        $userProfile = $user->userProfile;

        if ($userProfile) {
            if ($userProfile->carrinho) {
                $userProfile->carrinho->delete();
            }
            if ($userProfile->favorito) {
                $userProfile->favorito->delete();
            }
            $userProfile->delete();
        }

        \Yii::$app->db->createCommand()
            ->delete('auth_assignment', ['user_id' => $user->id])
            ->execute();

        $user->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
