<?php

class m140701_070503_alter_table_users_create_fields_email_mobilenumber extends CDbMigration
{
	public function up()
	{
		$this->addColumn("{{users}}", 'email', 'VARCHAR(128) NOT NULL DEFAULT 1');
		$this->addColumn("{{users}}", 'mobile_number', 'VARCHAR(15) NOT NULL DEFAULT 1');
	}

	public function down()
	{
		echo "m140701_070503_alter_table_users_create_fields_email_mobilenumber does not support migration down.\n";
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