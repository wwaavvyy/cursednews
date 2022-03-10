<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\Commentary;
use app\models\CommentaryForm;
use app\models\SearchForm;
use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\data\Pagination;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $data = Category::getAllCategoriesWithPagination();
        $popularArticles = Article::getPopularArticles();
        $newArticles = Article::getNewArticles();

        $search = new SearchForm();

        return $this->render('index', [
            'popularArticles' => $popularArticles,
            'newArticles' => $newArticles,
            'categories' => $data['categories'],
            'paginationCat' => $data['paginationCat'],
            'search' => $search,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
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

    public function actionView($id)
    {
        $article = Article::findOne($id);

        $selectedTags = $article->getSelectedTagsWithNames();

        $data = Category::getAllCategoriesWithPagination();

        $comments = $article->comments;
        ArrayHelper::multisort($comments, ['datestamp'], [SORT_DESC]);

        $commentForm = new CommentaryForm;

        $search = new SearchForm();

        return $this->render('view', [
            'article' => $article,
            'categories' => $data['categories'],
            'paginationCat' => $data['paginationCat'],
            'comments' => $comments,
            'commentForm' => $commentForm,
            'search' => $search,
            'selectedTags' => $selectedTags,
        ]);
    }

    public function actionCategory($id)
    {
        $data = Category::getAllCategoriesWithPagination();

        $categoryName = Category::findOne($id)->name;

        $query = Article::getArticlesByCategory($id);
        $count = $query->count();
        $paginationArt = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $articles = $query->offset($paginationArt->offset)
            ->limit($paginationArt->limit)
            ->all();

        $search = new SearchForm();

        return $this->render('category', [
            'categoryName' => $categoryName,
            'articles' => $articles,
            'paginationArt' => $paginationArt,
            'categories' => $data['categories'],
            'paginationCat' => $data['paginationCat'],
            'search' => $search,
        ]);
    }

    // Метод регистрации
    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($user = $model->signUp()) {
                    if (Yii::$app->getUser()->login($user)) {
                        Yii::$app->user->login($user);
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function beforeAction($action)
    {
        $model = new SearchForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $searchLine = Html::encode($model->searchLine);
            return $this->redirect(Yii::$app->urlManager->createUrl(['site/search', 'searchLine' => $searchLine]));
        }
        return true;
    }

    public function actionSearch() {
        $data = Category::getAllCategoriesWithPagination();

        $searchLine = Yii::$app->getRequest()->getQueryParam('searchLine');
        $query = Article::getArticlesBySearchLine($searchLine);
        $count = $query->count();
        $paginationArt = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $articles = $query->offset($paginationArt->offset)
            ->limit($paginationArt->limit)
            ->all();

        $search = new SearchForm();

        return $this->render('search', [
            'articles' => $articles,
            'paginationArt' => $paginationArt,
            'categories' => $data['categories'],
            'paginationCat' => $data['paginationCat'],
            'search' => $search,
            'searchLine' => $searchLine,
        ]);
    }

    public function actionComment($id) {
        $model = new CommentaryForm;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->saveComment($id)) {
                return $this->redirect(['site/view', 'id' => $id]);
            }
        }
    }

    public function actionCommentDelete($id)
    {
        $model = Commentary::findOne($id);
        $article_id = $model->article_id;
        if ($model->user_id == Yii::$app->user->identity->id) {
            Yii::$app->session->setFlash('success', 'Ваш комментарий успешно удален');
            $model->delete();
        } else {
            Yii::$app->session->setFlash('error', 'При удалении комментария произошла ошибка');
        }
        return $this->redirect(['site/view', 'id' => $article_id]);
    }
}
