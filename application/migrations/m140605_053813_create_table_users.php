<?php

class m140605_053813_create_table_users extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            '{{users}}',
            array(
                'id'         	=> 'pk                   COMMENT "The automatic, machine-readable identifier (integer) for an item  represented in this table."',
                'username'    	=> 'VARCHAR(64) NOT NULL COMMENT "Users Username, used for logging in and alias identification"',
                'password'     	=> 'CHAR(60)    NOT NULL COMMENT "Password required to log in to the system"',
                'title'			=> 'INT             NULL',
                'firstname'     => 'VARCHAR(36) NOT NULL',
                'middlename'    => 'VARCHAR(36)     NULL',
                'lastname'      => 'VARCHAR(36) NOT NULL',
                'priv'      	=> 'INT         NOT NULL COMMENT "Level used to determine permissions and privileges"',
                'dob'     		=> 'INT         NOT NULL COMMENT "Unix timestamp of when the user was born"',
                'gender'        => 'BOOLEAN     NOT NULL COMMENT "False = Female, True = Male"',
                'branch'        => 'INT         NOT NULL COMMENT "The branch in which the user belongs to"',
                'created'    	=> 'INT         NOT NULL COMMENT "Unix timestamp of when the row was created."',
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
		$this->dropTable("{{users}}");
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