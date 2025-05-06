<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_api_list}}`.
 */
class m250422_162935_create_products_api_list_table extends Migration
{
    private $tableName = "products_api_list";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "product_id"=> $this->integer()->notNull(),
            "api_name"=> $this->string()->notNull(),
            "api_endpoint"=> $this->string()->notNull(),
            "api_method"=> $this->string()->notNull(),
            "api_params"=> $this->json(),
            "api_headers"=> $this->json(),
            "api_body"=> $this->json(),
            "api_response"=> $this->json(),
            "status"=> $this->integer()->notNull(),
            "added_on"=> $this->dateTime(),
            "updated_on"=> $this->dateTime(),
            "added_by"=> $this->integer(),
            "updated_by"=> $this->integer(),
        ]);
        $this->createIndex(
            'idx-products_api_list-product_id-api_name',
            $this->tableName,
            ['product_id','api_name'],
            true
        );
        $this->addForeignKey(
            'fk-products_api_list-product_id',
            $this->tableName,
            'product_id',
            'products',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-products_api_list-api_endpoint',
            $this->tableName,
            'api_endpoint',
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
