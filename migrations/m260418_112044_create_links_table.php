<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%links}}`.
 */
class m260418_112044_create_links_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('links', [
            'id' => $this->primaryKey(),
            'original_url' => $this->text()->notNull(),
            'short_code' => $this->string(10)->notNull()->unique(),
            'created_at' => $this->dateTime()->notNull(),
            'clicks' => $this->integer()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('links');
    }
}
