<?php

use yii\db\Migration;

class m180329_054224_init_db extends Migration
{
    public function safeUp()
    {
        $this->execute('CREATE EXTENSION IF NOT EXISTS postgis');
        $this->execute('CREATE EXTENSION IF NOT EXISTS btree_gist');
    }

    public function safeDown()
    {
        echo "m180329_054224_init_db be reverted.\n";

        return true;
    }
}
