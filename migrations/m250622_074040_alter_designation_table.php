<?php

use yii\db\Migration;

/**
 * Class m250622_074040_alter_designation_table
 */
class m250622_074040_alter_designation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('designation', 'menu', $this->json()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250622_074040_alter_designation_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250622_074040_alter_designation_table cannot be reverted.\n";

        return false;
    }
    */
}
