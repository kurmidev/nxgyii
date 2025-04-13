<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticket_comments}}`.
 */
class m250411_063434_create_ticket_comments_table extends Migration
{
    private $table = 'ticket_comments';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "ticket_id" => $this->integer()->notNull(),
            "comment" => $this->text()->notNull(),
            "attachment" => $this->json()->null(),
            "zoho_comment_id" => $this->string(100)->null(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
