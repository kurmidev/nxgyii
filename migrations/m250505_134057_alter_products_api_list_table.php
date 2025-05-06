<?php

use yii\db\Migration;

/**
 * Class m250505_134057_alter_products_api_list_table
 */
class m250505_134057_alter_products_api_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('products_api_list', 'is_pagination', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250505_134057_alter_products_api_list_table cannot be reverted.\n";
        $this->dropColumn('products_api_list', 'is_pagination');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250505_134057_alter_products_api_list_table cannot be reverted.\n";

        return false;
    }
    */
}
