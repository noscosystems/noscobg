<?php

class m140605_080134_create_table_rooms extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            '{{rooms}}',
            array(
                'id' 		=> 'pk',
                'type' 		=> 'INT NOT NULL',
                'asset' 	=> 'INT NOT NULL',
                'area' 		=> 'DOUBLE NOT NULL',
                'desc' 		=> 'VARCHAR(256) NULL',
                'created'	=> 'INT NOT NULL',
                'created_by' => 'INT NOT NULL',

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
		$this->dropTable("{{rooms}}");
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