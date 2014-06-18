<?php

class m140618_151403_add_column_assets_owner extends CDbMigration
{
	public function up()
	{
		$this->addColumn("{{assets}}", "owner", "INT NOT NULL COMMENT 'The owner of the Asset'");
		$this->dropTable("{{owners}}");
	}

	public function down()
	{
		echo "m140618_151403_add_column_assets_owner does not support migration down.\n";
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
