<?php

use yii\db\Migration;

/**
 * Class m191209_031739_add_sales_status_column
 */
class m191209_031739_add_sales_status_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("customer","sales_status","string");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("customer", "sales_status");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191209_031739_add_sales_status_column cannot be reverted.\n";

        return false;
    }
    */
}
