<?php

use yii\db\Migration;

/**
 * Class m240516_140919_init
 */
class m240516_140919_init extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}',[
            'username'=>'admin',
            'auth_key'=>'2nUW-Jf-uxOC7OcOnxAyM7zqE6x5hzo8',
            'password_hash'=>'$2y$13$P9QioTsezdVZN1HCY3aaCefe/yAGWGpI7rwX4ezAWmfrwBpDh599O',
            'email' => 'admin@admin.ru',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }

}
