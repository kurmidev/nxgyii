<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m250422_161750_create_products_table extends Migration
{
    private $tableName = "products";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "name"=> $this->string()->notNull(),
            "code"=> $this->string()->notNull(),
            "description"=> $this->string(),
            "base_url"=> $this->string()->notNull(),
            "authentication_type"=> $this->integer()->notNull(),
            "login_headers"=> $this->json(),
            "auth_headers"=> $this->json(),
            "status"=> $this->integer()->notNull(),
            "added_on"=> $this->dateTime(),
            "updated_on"=> $this->dateTime(),
            "added_by"=> $this->integer(),
            "updated_by"=> $this->integer(),
        ]);

        $this->createIndex(
            'idx-products-name-code',
            $this->tableName,
            ['name','code'],
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
