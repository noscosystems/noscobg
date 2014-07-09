<?php

class m140709_114703_alterTableAssets_active extends CDbMigration
{
	public function up()
	{
		$this->addColumn("{{assets}}", 'active', 'BOOLEAN NOT NULL DEFAULT 1');
	}
	public function down()
	{
		echo "m140709_114703_alterTableAssets_active does not support migration down.\n";
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