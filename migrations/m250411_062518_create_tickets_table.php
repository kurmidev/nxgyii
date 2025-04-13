<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tickets}}`.
 */
class m250411_062518_create_tickets_table extends Migration
{
    private $table = 'tickets';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    { 
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'code'=> $this->string(100)->unique()->notNull(),
            "subject" => $this->string(100)->notNull(),
            "description" => $this->text()->notNull(),
            "priority" => $this->tinyInteger(1)->notNull(),
            "company_id" => $this->integer()->notNull(),
            "category_id" => $this->integer()->notNull(),
            "sub_category_id" => $this->integer()->notNull(),
            "assign_to" => $this->integer()->null(),
            "zoho_id" => $this->string(100)->null(),
            "start_date" => $this->date()->notNull(),
            "end_date" => $this->date()->null(),
            "rating"=> $this->tinyInteger(1)->null(),
            "status" => $this->tinyInteger(1)->notNull()->defaultValue(1),
            "resolution" => $this->text()->null(),
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
