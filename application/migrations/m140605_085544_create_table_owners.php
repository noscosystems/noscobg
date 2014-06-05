<?php

class m140605_085544_create_table_owners extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            '{{owners}}',
            array(
                'id'         	=> 'pk                   COMMENT "The automatic, machine-readable identifier (integer) for an item  represented in this table."',
                'asset'    		=> 'INT(11) 	NOT NULL COMMENT "asset.id"',
                'user'     		=> 'INT(11)    	NOT NULL COMMENT "user.id"',
                'created'		=> 'INT(11)     NOT NULL COMMENT "UNIX timestamp for date of creation"',
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
		echo "m140605_085544_create_table_owners does not support migration down.\n";
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