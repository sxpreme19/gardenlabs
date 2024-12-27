<?php

namespace backend\controllers;

use common\models\Produto;
use common\models\Imagem;
use backend\models\ImagemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadForm;
use yii\web\UploadedFile;
use Yii;
use yii\filters\AccessControl;

/**
 * ImagemController implements the CRUD actions for Imagem model.
 */
class ImagemController extends Controller
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
                            'actions' => ['index', 'view', 'upload', 'update'],
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
     * Lists all Imagem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ImagemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Imagem model.
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
     * Creates a new Imagem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionUpload($id)
    {
        if (!Produto::findOne($id)) {
            Yii::$app->session->setFlash('error', "Produto with ID $id does not exist.");
            return $this->redirect(['produto/index']);
        }

        $uploadForm = new UploadForm();

        if ($this->request->isPost) {
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');
            if ($uploadForm->validate() && $uploadForm->imageFiles) {
                foreach ($uploadForm->imageFiles as $file) {
                    $FileName = $id . '.' . $file->baseName . '.' . $file->extension;
                    $filePath = Yii::getAlias('@webroot/uploads/') . $FileName;

                    if (Imagem::find()->where(['filename' => $FileName])->exists()) {
                        Yii::$app->session->setFlash('error', "An image with the filename '$FileName' already exists in the database.");
                        return $this->redirect(['produto/manage-images', 'id' => $id]); 
                    }
    
                    if (file_exists($filePath)) {
                        Yii::$app->session->setFlash('error', "A file with the filename '$FileName' already exists on the server.");
                        return $this->redirect(['produto/manage-images', 'id' => $id]);
                    }

                    if ($file->saveAs($filePath)) {
                        $image = new Imagem();
                        $image->produto_id = $id;
                        $image->filename = $FileName;

                        if ($image->save()) {
                            Yii::$app->session->setFlash('success', 'Image uploaded: ' . $FileName);
                        } else {
                            Yii::$app->session->setFlash('error', 'Failed to save image: ' . json_encode($image->errors));
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to save file: ' . $FileName);
                    }
                }

                return $this->redirect(['produto/view', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', 'Validation failed: ' . json_encode($uploadForm->errors));
            }
        }

        $model = new Imagem();
        $model->produto_id = $id;

        return $this->render('upload', [
            'model' => $model,
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Deletes an existing Imagem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $filePath = Yii::getAlias('@webroot/uploads/' . $model->filename);
        if (file_exists($filePath)) {
            unlink($filePath); 
        }
        $model->delete();

        Yii::$app->session->setFlash('success', 'Image deleted successfully');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Imagem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Imagem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Imagem::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
