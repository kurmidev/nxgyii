<?php

use yii\db\Migration;

/**
 * Class m250505_152250_alter_product_company_mapping_table
 */
class m250505_152250_alter_product_company_mapping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("product_company_mapping", "headers", $this->json());
        $this->addColumn("product_company_mapping", "allowed_api", $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250505_152250_alter_product_company_mapping_table cannot be reverted.\n";
        $this->dropColumn("product_company_mapping", "headers");
        $this->dropColumn("product_company_mapping", "allowed_api");
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250505_152250_alter_product_company_mapping_table cannot be reverted.\n";

        return false;
    }
    */
}
