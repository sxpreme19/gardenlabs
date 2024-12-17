<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use frontend\models\UpdateUserForm;
use common\models\Userprofile;
use common\models\Favorito;

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
                    'only' => ['index', 'my-account', 'account-details', 'wishlist','cart','checkout','delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'my-account', 'account-details', 'wishlist','cart','checkout','delete'],
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
     * Displays cart page.
     *
     * @return mixed
     */
    public function actionCart()
    {
        $this->view->title = 'Cart';
        $this->view->params['breadcrumbs'] = [
        ['label' => 'Home', 'url' => ['site/index']],
        ['label' => $this->view->title],
        ];

        return $this->render('cart');
    }

    /**
     * Displays checkout page.
     *
     * @return mixed
     */
    public function actionCheckout()
    {
        return $this->render('checkout');
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
