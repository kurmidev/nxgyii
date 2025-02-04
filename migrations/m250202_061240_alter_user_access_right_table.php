<?php

use app\models\UserAccessRight;
use yii\db\Migration;

/**
 * Class m250202_061240_alter_user_access_right_table
 */
class m250202_061240_alter_user_access_right_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   
        //$this->addPrimaryKey(UserAccessRight::tableName(),"id",$this->integer()->notNull()->unique());
        try{
            $this->alterColumn(UserAccessRight::tableName(),"items",$this->json());
        }catch(Exception $e){

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250202_061240_alter_user_access_right_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250202_061240_alter_user_access_right_table cannot be reverted.\n";

        return false;
    }
    */
}
