<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "commentary".
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string $content
 * @property string $datestamp
 *
 * @property Article $article
 * @property User $user
 */
class Commentary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commentary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'content'], 'required'],
            [['user_id', 'article_id'], 'integer'],
            [['datestamp'], 'safe'],
            [['content'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'article_id' => 'Article ID',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
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

    // Получение списка новостей
    public function getArticles() {
        return $this->hasMany(Article::className(), ['id' => 'article_id']);
    }
}
