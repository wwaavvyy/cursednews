<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $isAdmin
 * @property string|null $photo
 * @property string $datestamp
 *
 * @property Article[] $articles
 * @property Commentary[] $commentaries
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['isAdmin'], 'integer'],
            [['datestamp'], 'safe'],
            [['username', 'password', 'email', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Email',
            'isAdmin' => 'Администратор',
            'photo' => 'Изображение',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Commentaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommentaries()
    {
        return $this->hasMany(Commentary::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    // Поиск по имени пользователя
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    // Генерация хэша для пароля
    public function setPassword($password)
    {
        return $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    // Проверка введенного пароля и хэша
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    // Получение роли пользователя
    public static function userRole($id) {
        $user = self::findOne(['id' => $id]);
        return $user->isAdmin ? 'Администратор' : 'Пользователь';
    }

    // Сохранение изображения
    public function savePhoto($filename) {
        $this->photo = $filename;
        return $this->save(false);
    }
}
