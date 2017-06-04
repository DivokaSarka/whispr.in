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
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%note}}');
    }
}
