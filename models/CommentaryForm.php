<?php

namespace app\models;

use Yii;
use yii\base\Model;


class CommentaryForm extends Model
{
    public $content;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string', 'length' => [3, 255]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'content' => 'Комментарий',
        ];
    }

    public function saveComment($article_id) {
        $comment = new Commentary;
        $comment->content = $this->content;
        $comment->user_id = Yii::$app->user->identity->id;
        $comment->article_id = $article_id;

        return $comment->save();
    }
}
