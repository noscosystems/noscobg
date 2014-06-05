<?php

class m140605_094116_create_table_option extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            '{{option}}',
            array(
                'id'            => 'pk                                      COMMENT ""',
                'table'         => 'VARCHAR(64)    NOT NULL                 COMMENT ""',
                'column'        => 'VARCHAR(64)    NOT NULL                 COMMENT ""',
                'name'          => 'VARCHAR(128)   NOT NULL                 COMMENT ""',
                'data'          => 'TEXT                                    COMMENT ""',
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
		$this->dropTable("{{option}}");
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