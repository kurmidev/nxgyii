<?php

use yii\db\Migration;

/**
 * Class m250517_114312_alter_employee_table
 */
class m250517_114312_alter_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('employee', 'component_id', $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250517_114312_alter_employee_table cannot be reverted.\n";
        $this->dropColumn('employee', 'component_id');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250517_114312_alter_employee_table cannot be reverted.\n";

        return false;
    }
    */
}
