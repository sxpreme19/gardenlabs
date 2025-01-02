<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Favorito;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Produto;
use common\models\Categoria;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['signup', 'login', 'reset-password', 'index', 'contact', 'about', 'logout'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'reset-password', 'index', 'contact', 'about'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'contact', 'about'],
                        'allow' => true,
                        'roles' => ['client'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('warning', 'You must be logged in to log out.');
                            return Yii::$app->response->redirect(['site/login']);
                        }
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->can('accessBackend');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (isset(Yii::$app->user->identity->userProfile)) {
            $userProfile = Yii::$app->user->identity->userProfile;
            $userWishlist = Favorito::find()->where(['userprofile_id' => $userProfile->user_id,])->with('produto')->all();
            $userWishlistIds = ArrayHelper::getColumn($userWishlist, 'produto_id');
        } else {
            $userWishlistIds = null;
            Yii::$app->session->setFlash('info', 'Login to get access to all the features! (Cart,Wishlist,Reviews... And much more!)');
        }

        $categories = Categoria::find()->limit(3)->all();

        $categoryImages = [
            'images/category1.jpg',
            'images/categories_img_03.jpg',
            'images/categories_img_2.jpg'
        ];

        $bestSellers = Produto::find()
        ->joinWith('linhafaturas')  
        ->select(['produto.id', 'produto.nome','produto.preco', 'COUNT(linhafatura.id) AS sales_count'])
        ->groupBy('produto.id')
        ->orderBy(['sales_count' => SORT_DESC]) 
        ->limit(4)
        ->all();

        $this->view->title = 'Home';
        return $this->render('index',[
            'bestSellers' => $bestSellers,
            'userWishlistIds' => $userWishlistIds,
            'categories' => $categories,
            'categoryImages' => $categoryImages,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        $this->view->title = 'Login';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration!');
            return $this->goHome();
        }

        $this->view->title = 'Sign up';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        $this->view->title = 'Contact';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $this->view->title = 'About Us';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('about');
    }

    /**
     * Resets password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword()
    {
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->resetPassword()) {
                Yii::$app->session->setFlash('success', 'Your password has been reset successfully.');
                return $this->goHome();
            }
        }

        $this->view->title = 'Reset Password';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Home', 'url' => ['site/index']],
            ['label' => $this->view->title],
        ];

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
