<?php

use yii\db\Migration;

/**
 * Class m250501_155616_alter_products_table
 */
class m250501_155616_alter_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('products', 'login_endpoint', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250501_155616_alter_products_table cannot be reverted.\n";
        $this->dropColumn('products', 'login_endpoint');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250501_155616_alter_products_table cannot be reverted.\n";

        return false;
    }
    */
}
