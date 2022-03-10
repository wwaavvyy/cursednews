<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PhotoUpload;
use Yii;
use yii\web\UploadedFile;

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
     * Displays a single User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
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

    public function actionSetphoto($id) {
        if ($id != Yii::$app->user->identity->id) {
            Yii::$app->session->setFlash('danger', 'Данное действие запрещено');
            return $this->redirect('/site/index');
        }

        $model = New PhotoUpload;

        if (Yii::$app->request->isPost) {
            $user = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'photo');

            if ($user->savePhoto($model->photoUpload($file, $user->photo))) {
                Yii::$app->session->setFlash('success', 'Аватарка успешно изменена');
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }

        return $this->render('setphoto', [
            'model' => $model,
        ]);
    }
}
