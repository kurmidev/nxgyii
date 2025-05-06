<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_company_mapping}}`.
 */
class m250422_170516_create_product_company_mapping_table extends Migration
{
    private $tableName = "product_company_mapping";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "product_id"=> $this->integer()->notNull(),
            "company_id"=> $this->integer()->notNull(),
            "credentials"=> $this->json(),
            "status"=> $this->integer()->notNull(),
            "added_on"=> $this->dateTime(),
            "updated_on"=> $this->dateTime(),
            "added_by"=> $this->integer(),
            "updated_by"=> $this->integer(),
        ]);
        $this->createIndex(
            'idx-product_company_mapping-product_id-company_id',
            $this->tableName,
            ['product_id','company_id'],
            true
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
