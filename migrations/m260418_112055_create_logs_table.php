<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logs}}`.
 */
class m260418_112055_create_logs_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('logs', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull(),
            'ip' => $this->string(45),
            'created_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-log-link_id', 'logs');
        $this->dropTable('logs');
    }
}
