<?php

class m140721_095902_insertIntoTableOption extends CDbMigration
{
	public function up()
    {
        $this->insert('{{option}}', array(
            'id' => 7,
            'table' => 'rooms',
            'column' => 'room_type',
            'name' => 'bedroom'
        ));
        $this->insert('{{option}}', array(
            'id' => 8,
            'table' => 'rooms',
            'column' => 'room_type',
            'name' => 'lving room'
        ));
        $this->insert('{{option}}', array(
            'id' => 9,
            'table' => 'rooms',
            'column' => 'room_type',
            'name' => 'kitchen'
        ));
        
    }

	public function down()
	{
		echo "m140721_095902_insertIntoTableOption does not support migration down.\n";
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