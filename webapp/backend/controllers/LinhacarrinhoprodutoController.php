<?php

namespace backend\controllers;

use common\models\Linhacarrinhoproduto;
use backend\models\LinhacarrinhoprodutoSearch;
use common\models\Carrinhoproduto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LinhacarrinhoprodutoController implements the CRUD actions for Linhacarrinhoproduto model.
 */
class LinhacarrinhoprodutoController extends Controller
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
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['index', 'view', 'create', 'update'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page.');
                    },
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
     * Lists all Linhacarrinhoproduto models.
     *
     * @return string
     */
    public function actionIndex($id = null)
    {
        $searchModel = new LinhacarrinhoprodutoSearch();
        $searchModel->carrinhoproduto_id = $id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Linhacarrinhoproduto model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Linhacarrinhoproduto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Linhacarrinhoproduto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $userCart = Carrinhoproduto::findOne(['id' => $model->carrinhoproduto_id]);
                if ($userCart) {
                    $userCart->total = $userCart->calculateTotal();
                    $userCart->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Linhacarrinhoproduto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $userCart = Carrinhoproduto::findOne($model->carrinhoproduto_id);
                if ($userCart) {
                    $userCart->total = $userCart->calculateTotal();
                    $userCart->save();
                }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Linhacarrinhoproduto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $cartLine = Linhacarrinhoproduto::findOne($id);
        $userCart = Carrinhoproduto::findOne(['id' => $cartLine->carrinhoproduto_id]);
                if ($userCart) {
                    $userCart->total -= $cartLine->precounitario * $cartLine->quantidade; 
                    $userCart->save();
                }
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Linhacarrinhoproduto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Linhacarrinhoproduto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Linhacarrinhoproduto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
