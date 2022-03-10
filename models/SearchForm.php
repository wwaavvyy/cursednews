<?php

namespace app\models;

use yii\base\Model;

class SearchForm extends Model
{
    public $searchLine;

    public function rules()
    {
        return [
            [['searchLine'], 'required'],
            [['searchLine'], 'string', 'max' => 50],
        ];
    }
}
