<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use common\models\Produto;
use common\models\Servico;
use common\models\Fatura;
use common\models\ResetPasswordForm;
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
                'only' => ['login', 'reset-password', 'error', 'index', 'logout'],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['client'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->user->logout();
                            Yii::$app->session->setFlash('warning', 'You must have backend access.');
                            return $this->redirect(['login']);
                        },
                    ],
                    [
                        'actions' => ['login', 'error', 'reset-password'],
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

        $mostSoldProducts = (new \yii\db\Query())
            ->select(['produto_id', 'SUM(quantidade) AS total_quantity_sold'])
            ->from('linhafatura')
            ->groupBy('produto_id')
            ->orderBy(['total_quantity_sold' => SORT_DESC])
            ->limit(5);

        $salesData = $mostSoldProducts->all();

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

        $bestProductRatings = (new \yii\db\Query())
            ->select(['produto_id', 'AVG(avaliacao) AS average_rating'])
            ->from('review')
            ->groupBy('produto_id')
            ->orderBy(['average_rating' => SORT_DESC])
            ->limit(5);

        $ratingData = $bestProductRatings->all();

        $ratingLabels = [];
        $ratingDataValues = [];
        foreach ($ratingData as $rating) {
            $product = Produto::findOne($rating['produto_id']);
            if ($product) {
                $ratingLabels[] = $product->nome;
                $ratingDataValues[] = (float) $rating['average_rating'];
            }
        }

        $mostSoldServices = (new \yii\db\Query())
            ->select(['servico_id', 'SUM(quantidade) AS total_quantity_sold'])
            ->from('linhafatura')
            ->groupBy('servico_id')
            ->orderBy(['total_quantity_sold' => SORT_DESC])
            ->limit(5);

        $mostSoldData = $mostSoldServices->all();

        $mostSoldLabels = [];
        $mostSoldDataValues = [];
        foreach ($mostSoldData as $sale) {
            $service = Servico::findOne($sale['servico_id']);
            if ($service) {
                $mostSoldLabels[] = $service->nome;
                $mostSoldDataValues[] = (int) $sale['total_quantity_sold'];
            }
        }

        $bestServiceRatings = (new \yii\db\Query())
            ->select(['servico_id', 'AVG(avaliacao) AS average_rating'])
            ->from('review')
            ->groupBy('servico_id')
            ->orderBy(['average_rating' => SORT_DESC])
            ->limit(5);

        $ratingData = $bestServiceRatings->all();

        $ratingLabelsServices = [];
        $ratingDataValuesServices = [];
        foreach ($ratingData as $rating) {
            $service = Servico::findOne($rating['servico_id']);
            if ($service) {
                $ratingLabelsServices[] = $service->nome;
                $ratingDataValuesServices[] = (float) $rating['average_rating'];
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
            'ratingLabels' => $ratingLabels,
            'ratingData' => $ratingDataValues,
            'mostSoldLabels' => $mostSoldLabels,
            'mostSoldDataValues' => $mostSoldDataValues,
            'ratingLabelsServices' => $ratingLabelsServices,
            'ratingDataValuesServices' => $ratingDataValuesServices,
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

    public function actionResetPassword()
    {
        $this->layout = 'main-login';

        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->resetPassword()) {
                Yii::$app->session->setFlash('success', 'Your password has been reset successfully.');
                return $this->goHome();
            }
        }

        return $this->render('reset-password', [
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
