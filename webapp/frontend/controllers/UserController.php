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
use common\models\User;
use common\models\Fatura;
use common\models\FaturaSearch;

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
                    'only' => ['index', 'my-account', 'account-details', 'purchase-history', 'purchase-details', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'my-account', 'account-details', 'purchase-history', 'purchase-details', 'delete'],
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
        $this->view->title = 'My Account';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('index');
    }

    /**
     * Displays My-Account page.
     *
     * @return mixed
     */
    public function actionMyAccount()
    {
        $userProfile = Userprofile::findOne(['user_id' => Yii::$app->user->id]);

        $this->view->title = 'Account Details';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'My Account', 'url' => ['user/index']],
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
     * Displays purchase-history page.
     *
     * @return mixed
     */
    public function actionPurchaseHistory()
    {
        $query = Fatura::find()
            ->joinWith('linhafaturas')
            ->where(['linhafatura.servico_id' => null])
            ->groupBy('fatura.id');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);

        $this->view->title = 'Purchase History';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'My Account', 'url' => ['user/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('purchase-history', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays purchase-details page.
     *
     * @return mixed
     */
    public function actionPurchaseDetails($id)
    {
        $userProfile = Userprofile::findOne(['user_id' => Yii::$app->user->id]);
        $invoice = Fatura::findOne(['id' => $id]);

        $shippingMethod = $invoice->metodoexpedicao;
        $paymentMethod = $invoice->metodopagamento;

        $this->view->title = 'Purchase Details';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Purchase History', 'url' => ['user/purchase-history']],
            ['label' => $this->view->title],
        ];

        return $this->render('purchase-details', [
            'invoice' => $invoice,
            'userProfile' => $userProfile,
            'paymentMethod' => $paymentMethod,
            'shippingMethod' => $shippingMethod,
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
            if ($userProfile->carrinhoproduto) {
                $userProfile->carrinhoproduto->delete();
                foreach ($userProfile->carrinhoproduto->linhacarrinhoprodutos as $linha) {
                    $linha->delete();
                }
            }
            if ($userProfile->carrinhoservico) {
                $userProfile->carrinhoservico->delete();
                foreach ($userProfile->carrinhoservico->linhacarrinhoservicos as $linha) {
                    $linha->delete();
                }
            }
            if ($userProfile->favoritos) {
                foreach ($userProfile->favoritos as $favorito) {
                    $favorito->delete();
                }
            }
            if ($userProfile->reviews) {
                foreach ($userProfile->reviews as $review) {
                    $review->delete();
                }
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
