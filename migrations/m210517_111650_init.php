<?php

use yii\db\Migration;
use app\models\Users;

/**
 * Class m210517_111650_init
 */
class m210517_111650_init extends Migration
{
    public function up()
    {

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'text' => $this->text(),
            'is_visible' => $this->boolean(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('author', '{{%messages}}', 'user_id', '{{%users}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%messages}}');
        $this->dropTable('{{%users}}');

        return false;
    }
}
