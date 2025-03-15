<?php

use app\models\ProductAttributes;
use yii\db\Migration;

/**
 * Class m250313_065522_alter_product_attribute_table
 */
class m250313_065522_alter_product_attribute_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(ProductAttributes::tableName(),"attr_for",$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250313_065522_alter_product_attribute_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250313_065522_alter_product_attribute_table cannot be reverted.\n";

        return false;
    }
    */
}
