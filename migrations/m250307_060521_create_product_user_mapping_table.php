<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_user_mapping}}`.
 */
class m250307_060521_create_product_user_mapping_table extends Migration
{
    public $table = "product_user_mapping";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'user_id' => $this->integer(),
            'user_type'=>$this->integer(),
            'added_on' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_on' => $this->timestamp()->null(),
            'added_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->createIndex($this->table."_product_id-user_id-user_type",$this->table,['user_id' ,'user_type','product_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
