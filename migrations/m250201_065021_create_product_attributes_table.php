<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_attributes}}`.
 */
class m250201_065021_create_product_attributes_table extends Migration
{
    protected $tableName = "product_attributes";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "product_id" => $this->integer(),
            "attr_value" => $this->string(),
            "attr_type" => $this->string(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->createIndex(
            'idx-' . $this->tableName . '-product_id',
            $this->tableName,
            ['product_id']
        );
        $this->createIndex(
            'idx-' . $this->tableName . '-product_id-attr_type',
            $this->tableName,
            ['product_id', "attr_type"],
            1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-' . $this->tableName . '-product_id',
            $this->tableName
        );
        $this->dropIndex(
            'idx-' . $this->tableName . '-product_id-attr_type',
            $this->tableName,
        );
        $this->dropTable($this->tableName);
    }
}
