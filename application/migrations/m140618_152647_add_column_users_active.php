<?php

class m140618_152647_add_column_users_active extends CDbMigration
{
	public function up()
	{
		$this->addColumn("{{users}}", 'active', 'BOOLEAN NOT NULL DEFAULT 1');
	}

	public function down()
	{
		echo "m140618_152647_add_column_users_active does not support migration down.\n";
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
