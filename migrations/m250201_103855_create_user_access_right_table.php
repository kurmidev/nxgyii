<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_access_right}}`.
 */
class m250201_103855_create_user_access_right_table extends Migration
{
    protected $tableName = 'user_access_right';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'role_name' => $this->string(255)->notNull(),
            'items' => $this->text()->notNull(),
            'added_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_on' => $this->timestamp()->null(),
            'added_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createIndex(
            'idx-'. $this->tableName. '-role_name',
            $this->tableName,
            ['role_name'],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
