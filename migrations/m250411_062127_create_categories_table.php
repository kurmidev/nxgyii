<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m250411_062127_create_categories_table extends Migration
{
    private $table = 'categories';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            "name" => $this->string(100)->unique()->notNull(),
            "parent_id" => $this->integer()->notNull()->defaultValue(0),
            "type" => $this->tinyInteger(1)->notNull(),
            "description" => $this->text(),
            "status" => $this->tinyInteger(1)->notNull()->defaultValue(1),
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
