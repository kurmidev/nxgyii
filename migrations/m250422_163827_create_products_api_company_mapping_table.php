<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products_api_company_mapping}}`.
 */
class m250422_163827_create_products_api_company_mapping_table extends Migration
{
    private $tableName = "products_api_company_mapping";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        try{
            $this->dropTable($this->tableName);
        }catch(Exception $e){
            print_r($e);
        }
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "product_id"=> $this->integer()->notNull(),
            "company_id"=> $this->integer()->notNull(),
            "api_id"=> $this->integer()->notNull(),
            "report_name"=> $this->string()->notNull(),
            "display_type"=> $this->tinyInteger()->notNull(),
            "filters"=>  $this->json(),
            "display_columns"=> $this->json(),
            "on_main_dashboard"=> $this->tinyInteger()->notNull(),
            "status"=> $this->integer()->notNull(),
            "added_on"=> $this->dateTime(),
            "updated_on"=> $this->dateTime(),
            "added_by"=> $this->integer(),
            "updated_by"=> $this->integer(),
        ]);
        $this->createIndex(
            'idx-products_api_company_mapping-product_id-company_id-api_id',
            $this->tableName,
            ['product_id','company_id','api_id'],
            false
        );
        $this->addForeignKey(
            'fk-products_api_company_mapping-product_id',
            $this->tableName,
            'product_id',
            'products',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-products_api_company_mapping-company_id',
            $this->tableName,
            'company_id',
            'company',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-products_api_company_mapping-api_id',
            $this->tableName,
            'api_id',
            'products_api_list',
            'id',
            'CASCADE'
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
