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
 *
 * @property Article[] $articles
 * @property Commentary[] $commentaries
 */
class SignupForm extends User
{
    public $passwordRepeat;
    public $agreement;

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
            [['username', 'password', 'email', 'agreement', 'passwordRepeat'], 'required'],
            [['isAdmin'], 'integer'],
            [['username'], 'unique'],
            [['email'], 'email'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'Логин должен быть написан латиницей'],
            [['agreement'], 'compare', 'compareValue' => true, 'message' => 'Пожалуйста, дайте согласие на обработку персональных данных'],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
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
            'passwordRepeat' => 'Повтор пароля',
            'email' => 'Email',
            'isAdmin' => 'Администратор',
            'photo' => 'Изображение',
            'agreement' => 'Согласие на обработку персональных данных',
        ];
    }

    // Метод регистрации
    public function signUp() {
        if(!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->username);
        $user->email = $this->email;

        return $user->save() ? $user : null;
    }


}
