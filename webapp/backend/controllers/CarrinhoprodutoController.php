<?php

namespace backend\controllers;

use common\models\Carrinhoproduto;
use backend\models\CarrinhoprodutoSearch;
use common\models\Userprofile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\AccessControl;

/**
 * CarrinhoprodutoController implements the CRUD actions for Carrinhoproduto model.
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
                    'only' => ['index', 'view', 'upload', 'delete'],
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
     * Lists all Carrinhoproduto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CarrinhoprodutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Carrinhoproduto model.
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
     * Creates a new Carrinhoproduto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Carrinhoproduto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $userProfile = Userprofile::findOne($model->userprofile_id);
                if ($userProfile) {
                    if ($model->total === null || $model->total === '') {
                        $model->total = 0;
                    }
                    $existingCart = Carrinhoproduto::findOne(['userprofile_id' => $model->userprofile_id]);
                    if ($existingCart) {
                        Yii::$app->session->setFlash('error', 'This user already has a cart.');
                    } else if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'User Profile not found.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Carrinhoproduto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $userProfile = Userprofile::findOne($model->userprofile_id);
                if ($userProfile) {
                    if ($model->total === null || $model->total === '') {
                        $model->total = 0;
                    }
                    $existingCart = Carrinhoproduto::find()
                        ->where(['userprofile_id' => $model->userprofile_id])
                        ->andWhere(['<>', 'id', $model->id])
                        ->one();

                    if ($existingCart) {
                        Yii::$app->session->setFlash('error', 'This user already has a cart.');
                    } else if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'User Profile not found.');
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Carrinhoproduto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Carrinhoproduto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Carrinhoproduto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrinhoproduto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
