<?php

class m140605_084444_create_table_address extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            '{{address}}',
            array(
                'id' 			=> 'pk',
                'number' 		=> 'INT NULL ',
                'name' 			=> 'VARCHAR(64) NULL',
                'flat' 			=> 'INT NULL',
                'zip_pc' 		=> 'VARCHAR(12) NOT NULL',
                'discrict' 		=> 'VARCHAR(64) NULL',
                'town'			=> 'VARCHAR(64) NOT NULL',
                'street'	 	=> 'VARCHAR(64) NULL',
                'country' 		=> 'VARCHAR(64) NULL',
                'county' 		=> 'VARCHAR(64) NOT NULL',
                'created'		=> 'INT NOT NULL',
                

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
		$this->dropTable("{{address}}");
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