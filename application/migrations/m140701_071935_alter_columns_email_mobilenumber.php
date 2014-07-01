<?php

class m140701_071935_alter_columns_email_mobilenumber extends CDbMigration
{
	public function up()
	{
		$this->alterColumn( "{{users}}", 'email', 'VARCHAR(128)' );
		$this->alterColumn( "{{users}}", 'mobile_number', 'VARCHAR(15)' );
	}

	public function down()
	{
		echo "m140701_071935_alter_columns_email_mobilenumber does not support migration down.\n";
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