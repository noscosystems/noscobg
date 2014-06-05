<?php

class m140605_081124_create_table_images extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            '{{images}}',
            array(
                'id'         	=> 'pk                    COMMENT "The automatic, machine-readable identifier (integer) for an item  represented in this table."',
                'name'    		=> 'VARCHAR(128) NOT NULL COMMENT "Name of the image"',
                'url'     		=> 'VARCHAR(256) NOT NULL COMMENT "Url to the image"',
                'asset'			=> 'INT          NOT NULL COMMENT "The ID of the asset (assets.id)"',
                'created'    	=> 'INT          NOT NULL COMMENT "Unix timestamp of when the row was created."',
            ),
            implode(' ', array(
                'ENGINE          = InnoDB',
                'DEFAULT CHARSET = utf8',
                'COLLATE         = utf8_general_ci',
                'COMMENT         = ""',
                'AUTO_INCREMENT  = 1',
            ))
        );
	}

	public function down()
	{
		$this->dropTable("{{images}}");
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