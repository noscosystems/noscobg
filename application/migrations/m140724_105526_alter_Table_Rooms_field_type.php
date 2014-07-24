<?php

class m140724_105526_alter_Table_Rooms_field_type extends CDbMigration
{
	public function up()
	{
		$this->dropForeignKey('fk_rooms_type_type',"{{rooms}}");
		$this->alterColumn("{{rooms}}",'type','VARCHAR(30)');
	}

	public function down()
	{
		echo "m140724_105526_alter_Table_Rooms_field_type does not support migration down.\n";
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