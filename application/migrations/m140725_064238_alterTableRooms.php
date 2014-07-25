<?php

class m140725_064238_alterTableRooms extends CDbMigration
{
	public function up()
	{
		$this->renameTable("{{rooms}}","{{features}}");
	}

	public function down()
	{
		echo "m140725_064238_alterTableRooms does not support migration down.\n";
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