<?php

use yii\db\Schema;
use yii\db\Migration;

class m150224_193333_create_new_tables extends Migration
{
    public function up()
    {
        $this->createTable('district', [
            'id' => 'pk NOT NULL AUTO_INCREMENT',
            'name' => 'string NOT NULL',
            'score' => 'int(11) NOT NULL',
			'UNIQUE KEY `name` (`name`)'
        ], 'ENGINE=InnoDB');

        $this->createTable('group', [
            'id' => 'pk NOT NULL AUTO_INCREMENT',
            'name' => 'string NOT NULL',
            'members' => 'string NOT NULL',
            'start_score' => 'int(11) NOT NULL',
			'UNIQUE KEY `name` (`name`)'
        ], 'ENGINE=InnoDB');

        $this->createTable('street', [
            'id' => 'pk NOT NULL AUTO_INCREMENT',
            'name' => 'string NOT NULL',
            'district_id' => 'int(11) NOT NULL',
            'score' => 'int(11) NOT NULL',
			'UNIQUE KEY `name` (`name`)'
        ], 'ENGINE=InnoDB');

        $this->createTable('grouptransaction', [
            'id' => 'pk NOT NULL AUTO_INCREMENT',
            'street_transaction_id' => 'int(11) NOT NULL',
            'group_id' => 'int(11) NOT NULL',
			'status' => 'int(11) NOT NULL',
            'score' => 'int(11) NOT NULL',
			'datetime' => 'datetime NOT NULL',
        ], 'ENGINE=InnoDB');

        $this->createTable('streettransaction', [
            'id' => 'pk NOT NULL AUTO_INCREMENT',
            'street_id' => 'int(11) NOT NULL',
            'group_id' => 'int(11) NOT NULL',
			'status' => 'int(11) NOT NULL',
			'start_datetime' => 'datetime NOT NULL',
			'end_datetime' => 'datetime NOT NULL',
        ], 'ENGINE=InnoDB');

		$this->addForeignKey(	'street_district_id',
								'street',
								'district_id',
								'district',
								'id',
								'RESTRICT',  // delete
								'CASCADE'); // update

		$this->addForeignKey(	'trans_group_id',
								'grouptransaction',
								'group_id',
								'group',
								'id',
								'RESTRICT',  // delete
								'CASCADE'); // update

		$this->addForeignKey(	'trans_group_street_trans_id',
								'grouptransaction',
								'street_transaction_id',
								'streettransaction',
								'id',
								'RESTRICT',  // delete
								'CASCADE'); // update

		$this->addForeignKey(	'trans_street_group_id',
								'streettransaction',
								'group_id',
								'group',
								'id',
								'RESTRICT',  // delete
								'CASCADE'); // update
		
		$this->addForeignKey(	'trans_street_street_id',
								'streettransaction',
								'street_id',
								'street',
								'id',
								'RESTRICT',  // delete
								'CASCADE'); // update

    }

    public function down()
    {
        echo "m150224_193333_create_new_tables cannot be reverted.\n";

        return false;
    }
}