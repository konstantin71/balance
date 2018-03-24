<?php

use yii\db\Migration;

/**
 * Class m180215_142358_init
 */
class m180215_142358_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('file',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'extension' => $this->string(),
            'save' => $this->boolean(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('file');
    }

}
