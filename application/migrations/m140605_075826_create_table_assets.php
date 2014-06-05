<?php

class m140605_075826_create_table_assets extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            '{{assets}}',
            array(
                'id'         	=> 'pk                   COMMENT "The automatic, machine-readable identifier (integer) for an item  represented in this table."',
                'name'    		=> 'VARCHAR(64) NOT NULL COMMENT "Name of the property"',
                'area'     		=> 'DOUBLE    	NOT NULL COMMENT "Password required to log in to the system"',
                'type'			=> 'INT(11)     NOT NULL',
                'rent_day'   	=> 'DOUBLE		    NULL COMMENT "Rent for a day"',
                'rent_week'     => 'DOUBLE 			NULL',
                'rent_month'    => 'DOUBLE 			NULL',
                'price'	        => 'DOUBLE 			NULL',
                'created'      	=> 'INT         NOT NULL COMMENT "Date of creation of the record in the db"',
                'created_by'   	=> 'INT         NOT NULL COMMENT "user.id"',
                'age'	        => 'INT     		NULL COMMENT "Age of the property"',
                'status'        => 'INT         NOT NULL COMMENT "option.id of property"',
                'short_desc'   	=> 'VARCHAR(128)	NULL COMMENT "Brief description of the property."',
                'long_desc'   	=> 'TEXT			NULL COMMENT "Longer description of the property."',
                'address'   	=> 'INT				NULL COMMENT "adress.id"',

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
		$this->dropTable("{{assets}}");
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