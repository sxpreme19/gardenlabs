<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use common\models\Produto;
use common\models\Servico;
use common\models\Fatura;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

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
                'only' => ['login', 'error', 'index', 'logout'],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['client'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('warning', 'You must have backend access.');
                            Yii::$app->user->logout();
                            return $this->redirect(['login']);
                        },
                    ],
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $roleCounts = (new \yii\db\Query())
            ->select(['item_name AS role', 'COUNT(*) AS user_count'])
            ->from('auth_assignment')
            ->groupBy('item_name')
            ->all();

        $roleData = [];
        foreach ($roleCounts as $role) {
            $roleData[$role['role']] = $role['user_count'];
        }

        $registeredUsers = User::find()->count();
        $existingProducts = Produto::find()->count();
        $existingServices = Servico::find()->count();

        $totalIncome = 0;
        $invoices = Fatura::find()->all();
        foreach ($invoices as $invoice) {
            $totalIncome += $invoice->total;
        }

        $query = (new \yii\db\Query())
            ->select(['produto_id', 'SUM(quantidade) AS total_quantity_sold'])
            ->from('linhafatura') 
            ->groupBy('produto_id')
            ->orderBy(['total_quantity_sold' => SORT_DESC]) 
            ->limit(10); 

        $salesData = $query->all();

        $productIds = array_column($salesData, 'produto_id');
        $products = Produto::find()->where(['id' => $productIds])->all();

        $labels = [];
        $data = [];
        foreach ($salesData as $sale) {
            foreach ($products as $product) {
                if ($product->id == $sale['produto_id']) {
                    $labels[] = $product->nome; 
                    $data[] = (int) $sale['total_quantity_sold'];
                }
            }
        }

        return $this->render('index', [
            'registeredUsers' => $registeredUsers,
            'roleData' => $roleData,
            'existingProducts' => $existingProducts,
            'existingServices' => $existingServices,
            'totalIncome' => $totalIncome,
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
