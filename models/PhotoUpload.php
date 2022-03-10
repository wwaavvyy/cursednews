<?php

namespace app\models;

use yii\base\Model;
use Yii;

class PhotoUpload extends Model {
    public $photo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp', 'maxSize' => 10 * 1024 * 1024],
            [['photo'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'photo' => 'Изображение',
        ];
    }

    public function photoUpload($file, $currentImage) {
        $this->photo = $file;

        if ($currentImage != 'default.jpg') {
            if (file_exists(Yii::$app->basePath . '/web/uploads/' . $currentImage)) {
                unlink(Yii::$app->basePath . '/web/uploads/' . $currentImage);
            }
        }

        if ($this->validate()) {
            $fileName = Yii::$app->security->generateRandomString() . '.' . $file->extension;
            $file->saveAs('@app/web/uploads/' . $fileName);
            return $fileName;
        }
    }
}