<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\User;
/**
 * ArticleController implements the CRUD actions for Article model.
 */
class UserController extends Controller
{
    // Создание администратора
    public function actionAddAdmin()
    {
        $model = User::find()->where(['username' => 'admin'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'admin';
            $user->setPassword('admin');
            $user->email = 'admin@gmail.com';
            $user->isAdmin = 1;
            if ($user->save()) {
                echo 'Администратор успешно добавлен';
            }
            else {
                echo 'Администратор не был создан';
            }
        }
        else {
            echo 'Администратор уже существует';
        }
    }
}
