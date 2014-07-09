<?php

class m140709_115403_insertIntoTableOptionStatusType extends CDbMigration
{
	 public function up()
    {
        $this->insert('{{option}}', array(
            'id' => 1,
            'table' => 'assets',
            'column' => 'status',
            'name' => 'Sell'
        ));
        $this->insert('{{option}}', array(
            'id' => 2,
            'table' => 'assets',
            'column' => 'status',
            'name' => 'Buy'
        ));
        $this->insert('{{option}}', array(
            'id' => 3,
            'table' => 'assets',
            'column' => 'status',
            'name' => 'Rent'
        ));
        $this->insert('{{option}}', array(
            'id' => 4,
            'table' => 'assets',
            'column' => 'type',
            'name' => 'House'
        ));
        $this->insert('{{option}}', array(
            'id' => 5,
            'table' => 'assets',
            'column' => 'type',
            'name' => 'Apartment'
        ));
        $this->insert('{{option}}', array(
            'id' => 6,
            'table' => 'assets',
            'column' => 'type',
            'name' => 'Land'
        ));
    }

	public function down()
	{
		echo "m140709_115403_insertIntoTableOptionStatusType does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}