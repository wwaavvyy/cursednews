<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\db\Query;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 *
 * @property Article[] $articles
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
            'name' => 'Название',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    // Получение списка всех категорий
    public static function getCategoryList()
    {
        return (new Query())
            ->select('name')
            ->from('category')
            ->indexBy('id')
            ->column();
    }

    // Получение количества новостей
    public function getArticlesCount() {
        return $this->getArticles()->count();
    }

    // Метод получения всех категорий вместе с пагинацией
    public static function getAllCategoriesWithPagination($pageSize = 10) {
        $query = Category::find();
        $count = $query->count();
        $paginationCat = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $categories = $query->offset($paginationCat->offset)
            ->limit($paginationCat->limit)
            ->all();

        $data['categories'] = $categories;
        $data['paginationCat'] = $paginationCat;

        return $data;
    }

    // Удаление изображений после удаления категории
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $articleDeleteList = Article::find()->select(['image'])->where(['category_id' => $this->id])->asArray()->all();

        foreach ($articleDeleteList as $item) {
            foreach ($item as $value) {
                if (!empty($value)) {
                    if (file_exists(Yii::$app->basePath . '/web/uploads/' . $value)) {
                        unlink(Yii::$app->basePath . '/web/uploads/' . $value);
                    }
                }
            }
        }

        return true;
    }
}
