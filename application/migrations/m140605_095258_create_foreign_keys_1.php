<?php

class m140605_095258_create_foreign_keys_1 extends CDbMigration
{
	public function up()
	{
		// $this->addForeignKey('name_of_key', '{{table_from}}', 'column_from', '{{table_to}}', 'column_to');
		// $this->addForeignKey('fk_assets_address_id', '{{assets}}', 'address', '{{address}}', 'id');

		//$this->addForeignKey('fk_users_title_option', '{{users}}', 'title', '{{option}}', 'id');
		$this->addForeignKey('fk_assets_type_option', '{{assets}}', 'type', '{{option}}', 'id');
		$this->addForeignKey('fk_assets_created_by_user', '{{assets}}', 'created_by', '{{users}}', 'id');
		$this->addForeignKey('fk_assets_address_address', '{{assets}}', 'address', '{{address}}', 'id');
		$this->addForeignKey('fk_images_asset_assets', '{{images}}', 'asset', '{{assets}}', 'id');
		//$this->addForeignKey('fk_owners_asset_assets', '{{owners}}', 'asset', '{{assets}}', 'id');
		$this->addForeignKey('fk_assets_user_users', '{{assets}}', 'owner', '{{users}}', 'id');
		$this->addForeignKey('fk_rooms_type_type', '{{rooms}}', 'type', '{{option}}', 'id');
		$this->addForeignKey('fk_rooms_asset_asset', '{{rooms}}', 'asset', '{{assets}}', 'id');
		$this->addForeignKey('fk_rooms_created_by_created_by', '{{rooms}}', 'created_by', '{{users}}', 'id');

	}

	public function down()
	{
		echo "m140605_095258_create_foreign_keys_1 does not support migration down.\n";
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