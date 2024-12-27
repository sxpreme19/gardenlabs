<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\Linhacarrinhoproduto;
use common\models\Carrinhoproduto;
use common\models\Produto;


/**
 *  CarrinhoprodutoController implements the CRUD actions for Carrinhoproduto model.
 */
class CarrinhoprodutoController extends Controller
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
                    'only' => ['index', 'add-to-cart', 'update-quantity','delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'add-to-cart', 'update-quantity','delete'],
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
     * Displays cart page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $userCart = Carrinhoproduto::findOne(['userprofile_id' => Yii::$app->user->identity->userProfile->id]);

        $this->view->title = 'Cart';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('index', ['userCart' => $userCart]);
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

        return $this->redirect(['carrinhoproduto/index']);
    }

    public function actionUpdateQuantity()
    {
        if (Yii::$app->request->isPost) {
            $itemId = Yii::$app->request->post('itemId');
            $quantity = Yii::$app->request->post('quantity');

            if ($itemId && $quantity && is_numeric($quantity) && $quantity > 0) {
                $cartItem = Linhacarrinhoproduto::findOne($itemId);
                if(!($quantity > $cartItem->produto->quantidade)) {
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
    
                            return $this->redirect(['carrinhoproduto/index']);
                        } else {
                            Yii::$app->session->setFlash('error', 'Failed to update cart item');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Cart item not found');
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'Not enough products available');
                }
                
            } else {
                Yii::$app->session->setFlash('error', 'Invalid quantity');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Removes cart item.
     *
     * @return mixed
     */
    public function actionDelete($cartItemId)
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $userCartItemtoRemove = Linhacarrinhoproduto::findOne(['id' => $cartItemId]);

        if (!$userCartItemtoRemove) {
            Yii::$app->session->setFlash('error', 'Item not found in cart.');
            return $this->redirect(['index']);
        }

        if ($userCartItemtoRemove->delete()) {
            $userCart = Carrinhoproduto::findOne(['userprofile_id' => $userProfile->id]);
            $userCart->total -= $userCartItemtoRemove->produto->preco * $userCartItemtoRemove->quantidade;
            $userCart->save();
            Yii::$app->session->setFlash('success', 'Item removed from cart successfully.');
            return $this->render('index', ['userCart' => $userCart]);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to remove item from cart.');
            return $this->redirect(['index']);
        }
    }
}
