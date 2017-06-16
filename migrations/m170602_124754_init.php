<?php

use yii\db\Migration;

class m170602_124754_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string(16)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'body' => $this->text()->notNull(),
            'email' => $this->string(),
            'file_path' => $this->string(),
            'lifetime' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-uid', '{{%note}}', 'uid');
        $this->createIndex('idx-lifetime', '{{%note}}', 'lifetime');
    }

    public function down()
    {
        $this->dropTable('{{%note}}');
    }
}
