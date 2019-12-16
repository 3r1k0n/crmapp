<?php

use yii\db\Migration;

class m150729_193243_init_customer_table extends Migration
{
    public function up()
    {
        $this->createTable(
            'customer',
            [
                'id' => 'pk',
                'name' => 'string',
                'birth_date' => 'date',
                'notes' => 'text',
                'attachment_path' => 'string'
            ],
        );
    }

    public function down()
    {
        $this->dropTable('customer');
    }
}
