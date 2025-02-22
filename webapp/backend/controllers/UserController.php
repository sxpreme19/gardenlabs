<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\CreateUserForm;
use backend\models\UpdateUserForm;

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
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'denyCallback' => function ($rule, $action) {
                                throw new \yii\web\ForbiddenHttpException('You are not allowed to acess this page.');
                            },
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CreateUserForm();

        if ($model->load(Yii::$app->request->post())) {
            $user = $model->create();
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException("User not found.");
        }

        $model = new UpdateUserForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            $postData = $this->request->post();

            if (isset($postData['roleDropDown'])) {
                $selectedRole = $postData['roleDropDown'];

                $authManager = Yii::$app->authManager;
                $authManager->revokeAll($model->id);

                $role = $authManager->getRole($selectedRole);
                if ($role) {
                    $authManager->assign($role, $model->id);
                }
            }
            Yii::$app->session->setFlash('success', 'User updated successfully.');
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
            }
            if ($userProfile->carrinhoservico) {
                $userProfile->carrinhoservico->delete();
            }
            if ($userProfile->favoritos) {
                $userProfile->favoritos->delete();
            }
            if($userProfile->reviews) {
                foreach($userProfile->reviews as $review) {
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
