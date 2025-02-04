<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%code_sequence}}`.
 */
class m250201_071400_create_code_sequence_table extends Migration
{
    protected $tableName = 'code_sequence';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "prefix"=> $this->string()->unique(),
            "counter"=> $this->integer()->defaultValue(0),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex(
            'idx-' . $this->tableName . '-prefix',
            $this->tableName,
            ['prefix'],
            1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-' . $this->tableName . '-prefix',
            $this->tableName,
        );
        $this->dropTable($this->tableName);
    }
}
