<?php

/**
 * This is the model class for table "rooms".
 *
 * The followings are the available columns in table 'rooms':
 * @property integer $id
 * @property integer $type
 * @property integer $asset
 * @property double $area
 * @property string $desc
 * @property integer $created
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Users $createdBy
 * @property Assets $asset0
 * @property Option $type0
 */
namespace application\models\db;

use \Yii;
use \CException;
use \application\components\ActiveRecord;

class Rooms extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rooms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, asset, area, created, created_by', 'required'),
			array('type, asset, created, created_by', 'numerical', 'integerOnly'=>true),
			array('area', 'numerical'),
			array('desc', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, asset, area, desc, created, created_by', 'safe', 'on'=>'search'),
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
			'CreatedBy' => array(self::BELONGS_TO, '\\application\\models\\db\\Users', 'created_by'),
			'Csset0' => array(self::BELONGS_TO, '\\application\\models\\db\\Assets', 'asset'),
			'Type0' => array(self::BELONGS_TO, '\\application\\models\\db\\Option', 'type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'asset' => 'Asset',
			'area' => 'Area',
			'desc' => 'Desc',
			'created' => 'Created',
			'created_by' => 'Created By',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('asset',$this->asset);
		$criteria->compare('area',$this->area);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rooms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
