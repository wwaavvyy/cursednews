<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $name
 *
 * @property Article[] $articles
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['status_id' => 'id']);
    }

    // Получение списка статусов
    public static function getStatusList()
    {
        return (new Query())
            ->select('name')
            ->from('status')
            ->indexBy('id')
            ->column();
    }
}
