<?php

namespace app\models;

use yii\base\Model;

/**
 * The model of the form file upload to the server
 *
 * Class FileForm
 * @package app\models
 */
class FileForm extends Model
{
    public $file;

    public function rules()
    {
        return [
           'file' => [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['html']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => '',
        ];
    }
}