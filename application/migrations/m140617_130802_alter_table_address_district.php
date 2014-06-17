<?php

class m140617_130802_alter_table_address_district extends CDbMigration
{
	public function up()
	{
		$this->renameColumn("{{address}}", "discrict", "district");
	}

	public function down()
	{
		echo "m140617_130802_alter_table_address_district does not support migration down.\n";
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