<?php

class m140721_102844_insertIntoTableOptionRoomType extends CDbMigration
{
	public function up()
	{
		 $this->insert('{{option}}', array(
            'id' => 10,
            'table' => 'rooms',
            'column' => 'room_type',
            'name' => 'bathroom'
        ));
	}

	public function down()
	{
		echo "m140721_102844_insertIntoTableOptionRoomType does not support migration down.\n";
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