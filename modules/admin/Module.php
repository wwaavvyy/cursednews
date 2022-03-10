<?php

namespace app\modules\admin;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '/admin';
    public $defaultRoute = 'article';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function () {
                    Yii::$app->session->setFlash('error', 'Это действие доступно только администратору!');
                    return Yii::$app->response->redirect('site/index');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function () {
                            if (!Yii::$app->user->isGuest) {
                                if (Yii::$app->user->identity->isAdmin == 1) {
                                    return true;
                                }
                            }
                            return false;
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
}
