<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property boolean $save
 */
class File extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'extension'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
