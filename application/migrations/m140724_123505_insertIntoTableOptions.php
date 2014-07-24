<?php

class m140724_123505_insertIntoTableOptions extends CDbMigration
{
	public function up()
	{
		$this->insert('{{option}}', array(
            'id' => 11,
            'table' => 'rooms',
            'column' => 'status',
            'name' => 'Rent or Sell'
        ));
	}

	public function down()
	{
		echo "m140724_123505_insertIntoTableOptions does not support migration down.\n";
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