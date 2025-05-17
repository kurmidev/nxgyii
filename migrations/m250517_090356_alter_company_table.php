<?php

use yii\db\Migration;

/**
 * Class m250517_090356_alter_company_table
 */
class m250517_090356_alter_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try{
            $this->addColumn('company', 'password', $this->text());
        }catch(Exception $e){
         
        }

        try{
            $this->addColumn('company', 'designation_id', $this->integer());
            $this->addForeignKey('fk_company_designation_id', 'company', 'designation_id', 'designation', 'id');
        }catch(Exception $e){

        }        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250517_090356_alter_company_table cannot be reverted.\n";
        $this->dropColumn('company', 'password');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250517_090356_alter_company_table cannot be reverted.\n";

        return false;
    }
    */
}
