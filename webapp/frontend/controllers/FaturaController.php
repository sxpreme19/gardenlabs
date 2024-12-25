<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Metodoexpedicao;
use common\models\Metodopagamento;
use common\models\Linhacarrinhoproduto;
use common\models\Carrinhoproduto;
use common\models\Produto;
use common\models\Fatura;
use common\models\Linhafatura;

/**
 * FaturaController implements the CRUD actions for Fatura model.
 */
class FaturaController extends Controller
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
                    'only' => ['index', 'confirm-checkout', 'confirm-order', 'order-confirmed'],
                    'rules' => [
                        [
                            'actions' => ['index', 'confirm-checkout', 'confirm-order', 'order-confirmed'],
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
     * Displays checkout page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $shippingMethods = Metodoexpedicao::find()->where(['disponivel' => 1])->all();
        $paymentMethods = Metodopagamento::find()->where(['disponivel' => 1])->all();
        $userCart = Carrinhoproduto::findOne(['userprofile_id' => Yii::$app->user->identity->userProfile->id]);
        $userProfile = Yii::$app->user->identity->userProfile;

        $this->view->title = 'Checkout';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Cart', 'url' => ['user/cart']],
            ['label' => $this->view->title],
        ];

        return $this->render('index', [
            'shippingMethods' => $shippingMethods,
            'paymentMethods' => $paymentMethods,
            'userCart' => $userCart,
            'userProfile' => $userProfile,
        ]);
    }

    /**
     * Displays confirm-checkout page.
     *
     * @return mixed
     */
    public function actionConfirmCheckout()
    {
        $userProfile = Yii::$app->user->identity->userProfile;
        $userCart = Carrinhoproduto::findOne(['userprofile_id' => $userProfile->id]);
        if (!$userCart) {
            Yii::$app->session->setFlash('error', 'No items found in your cart.');
            return $this->redirect(['carrinhoproduto/index']);
        }

        $selectedShippingMethodId = Yii::$app->request->post('shippingMethod');
        $selectedShippingMethod = Metodoexpedicao::findOne($selectedShippingMethodId);

        $selectedPaymentMethodId = Yii::$app->request->post('paymentMethod');
        $selectedPaymentMethod = Metodopagamento::findOne($selectedPaymentMethodId);

        $nome = Yii::$app->request->post('fullName');
        $morada = Yii::$app->request->post('address');
        $phone = Yii::$app->request->post('phone');
        $nif = Yii::$app->request->post('nif');

        if (
            $nome != $userProfile->nome ||
            $morada != $userProfile->morada ||
            $phone != $userProfile->telefone ||
            $nif != $userProfile->nif
        ) Yii::$app->session->setFlash('info', 'The billing information you provided is different from your profile data. Please confirm if everything is correct before proceeding.');

        if (!$selectedShippingMethod || !$selectedPaymentMethod) {
            Yii::$app->session->setFlash('error', 'Please select payment and shipping methods.');
            return $this->redirect(['index']);
        }

        $this->view->title = 'Confirm Checkout';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Cart', 'url' => ['carrinhoproduto/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('confirm-checkout', [
            'userCart' => $userCart,
            'shippingMethod' => $selectedShippingMethod,
            'paymentMethod' => $selectedPaymentMethod,
            'userProfile' => $userProfile,
            'nome' => $nome,
            'morada' => $morada,
            'phone' => $phone,
            'nif' => $nif,
        ]);
    }


    /**
     * Confirms order.
     *
     * @return mixed
     */
    public function actionConfirmOrder($shippingMethodId, $paymentMethodId, $fullName, $address, $phone, $nif)
    {

        $userCart = Carrinhoproduto::findOne(['userprofile_id' => Yii::$app->user->identity->userProfile->id]);
        $userProfile = Yii::$app->user->identity->userProfile;

        $shippingMethod = Metodoexpedicao::findOne($shippingMethodId);
        $paymentMethod = Metodopagamento::findOne($paymentMethodId);

        $shippingPrice = $shippingMethod->preco;
        $invoiceTotal = $userCart->total + $shippingPrice;

        $invoice = new Fatura();
        $invoice->userprofile_id = $userProfile->id;
        $invoice->metodopagamento_id = $paymentMethod->id;
        $invoice->metodoexpedicao_id = $shippingMethod->id;
        $invoice->total = $invoiceTotal;
        $invoice->datahora = date('Y-m-d H:i:s');
        $invoice->nome_destinatario = $fullName;
        $invoice->morada_destinatario = $address;
        $invoice->telefone_destinatario = $phone;
        $invoice->nif_destinatario = $nif;
        $invoice->preco_envio = $shippingPrice;

        if ($invoice->save()) {
            foreach ($userCart->linhacarrinhoprodutos as $cartItem) {
                $invoiceDetail = new Linhafatura();
                $invoiceDetail->fatura_id = $invoice->id;
                $invoiceDetail->produto_id = $cartItem->produto_id;
                $invoiceDetail->quantidade = $cartItem->quantidade;
                $invoiceDetail->precounitario = $cartItem->precounitario;
                $invoiceDetail->save();

                $product = Produto::findOne(['id' => $cartItem->produto_id]);
                $product->quantidade -= $cartItem->quantidade;
                $product->save();
            }

            Linhacarrinhoproduto::deleteAll(['carrinhoproduto_id' => $userProfile->carrinhoproduto->id]);
            $userCart->total = 0;
            $userCart->save();

            Yii::$app->session->setFlash('success', 'Your order has been confirmed!');
            return $this->redirect(['fatura/order-confirmed', 'invoiceID' => $invoice->id]);
        } else {
            Yii::$app->session->setFlash('error', 'There was an issue processing your order.');
            return $this->redirect(['carrinhoproduto/index']);
        }
    }

    /**
     * Displays order-confirmed page.
     *
     * @return mixed
     */
    public function actionOrderConfirmed($invoiceID)
    {
        $invoice = Fatura::findOne($invoiceID);
        $shippingMethod = $invoice->metodoexpedicao;
        $paymentMethod = $invoice->metodopagamento;
        $userProfile = Yii::$app->user->identity->userProfile;

        $this->view->title = 'Order Confirmed';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Cart', 'url' => ['carrinhoproduto/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('order-confirmation', [
            'shippingMethod' => $shippingMethod,
            'paymentMethod' => $paymentMethod,
            'userProfile' => $userProfile,
            'invoice' => $invoice,
        ]);
    }
}
