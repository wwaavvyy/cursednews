<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $datestamp
 * @property string $image
 * @property int $views
 * @property int $likes
 * @property int $user_id
 * @property int $status_id
 * @property int $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Category $category
 * @property Commentary[] $commentaries
 * @property Status $status
 * @property User $user
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'content', 'user_id', 'status_id', 'category_id', 'image'], 'required'],
            [['description', 'content'], 'string'],
            [['datestamp'], 'safe'],
            [['views', 'likes', 'user_id', 'status_id', 'category_id'], 'integer'],
            [['title',], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp', 'maxSize' => 10 * 1024 * 1024],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'content' => 'Текст новости',
            'datestamp' => 'Дата публикации',
            'image' => 'Изображение',
            'views' => 'Просмотры',
            'likes' => 'Оценка',
            'user_id' => 'Пользователь',
            'status_id' => 'Статус',
            'category_id' => 'Категория',
            'user.username' => 'Имя пользователя',
            'status.name' => 'Статус',
            'category.name' => 'Категория',
        ];
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Commentaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommentaries()
    {
        return $this->hasMany(Commentary::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    // Связь таблицы tag и article посредством таблицы article_tag
    public function getTags() {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    // Получение выбранных тегов
    public function getSelectedTags() {
        $selectedTagIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedTagIds, 'id');
    }

    // Получение выбранных тегов с названиями
    public function getSelectedTagsWithNames() {
        return $this->getTags()->select(['id', 'name'])->all();
    }

    // Сохранение тегов
    public function saveTags($tags) {
        if(is_array($tags)) {
            ArticleTag::deleteAll(['article_id' => $this->id]);
            foreach($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    // Получение популярных записей на главной
    public static function getPopularArticles($count = 4) {
        return Article::find()->where(['status_id' => 2])->orderBy(['views' => SORT_DESC])->limit($count)->all();
    }

    // Получение новых записей на главной
    public static function getNewArticles($count = 4) {
        return Article::find()->where(['status_id' => 2])->orderBy(['datestamp' => SORT_DESC])->limit($count)->all();
    }

    // Метод получения всех записей вместе с пагинацией
    public static function getAllArticlesWithPagination($pageSize = 10) {
        $query = Article::find();
        $count = $query->count();
        $paginationArt = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($paginationArt->offset)
            ->limit($paginationArt->limit)
            ->all();

        $data['articles'] = $articles;
        $data['paginationArt'] = $paginationArt;

        return $data;
    }

    // Удаление изображения после удаления новости
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if (!empty($this->image)) {
            if (file_exists(Yii::$app->basePath . '/web/uploads/' . $this->image)) {
                unlink(Yii::$app->basePath . '/web/uploads/' . $this->image);
            }
        }

        return true;
    }

    // Получение списка комментариев
    public function getComments() {
        return $this->hasMany(Commentary::className(), ['article_id' => 'id']);
    }

    // Получение списка новостей по строке поиска
    public static function getArticlesBySearchLine($searchLine) {
        return Article::find()->where(['status_id' => 2])->where(['like', 'title', $searchLine])->orderBy(['datestamp' => SORT_DESC]);
    }

    // Получение списка новостей по категории
    public static function getArticlesByCategory($id) {
        return Article::find()->where(['category_id' => $id])->orderBy(['datestamp' => SORT_DESC]);
    }
}
