<?php

/**
 * This is the model class for table "option".
 *
 * The followings are the available columns in table 'option':
 * @property integer $id
 * @property string $table
 * @property string $column
 * @property string $name
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Assets[] $assets
 * @property Rooms[] $rooms
 * @property Users[] $users
 */

namespace application\models\db;

use \Yii;
use \CException;
use \application\components\ActiveRecord;

class Option extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('table, column, name', 'required'),
			array('table, column', 'length', 'max'=>64),
			array('name', 'length', 'max'=>128),
			array('data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, table, column, name, data', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Assets' => array(self::HAS_MANY, 'application\\models\\db\\Assets', 'type'),
			'Rooms' => array(self::HAS_MANY, 'applicatio\\models\\db\\Rooms', 'type'),
			'Users' => array(self::HAS_MANY, 'application\\models\\db\\Users', 'title'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'table' => 'Table',
			'column' => 'Column',
			'name' => 'Name',
			'data' => 'Data',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('table',$this->table,true);
		$criteria->compare('column',$this->column,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Option the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
