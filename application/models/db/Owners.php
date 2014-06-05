<?php

/**
 * This is the model class for table "owners".
 *
 * The followings are the available columns in table 'owners':
 * @property integer $id
 * @property integer $asset
 * @property integer $user
 * @property integer $created
 *
 * The followings are the available model relations:
 * @property Users $user0
 * @property Assets $asset0
 */

namespace application\models\db;

use \Yii;
use \CException;
use \application\components\ActiveRecord;

class Owners extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'owners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asset, user, created', 'required'),
			array('asset, user, created', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, asset, user, created', 'safe', 'on'=>'search'),
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
			'User0' => array(self::BELONGS_TO, 'application\\models\\db\\Users', 'user'),
			'Asset0' => array(self::BELONGS_TO, 'application\\models\\db\\Assets', 'asset'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'asset' => 'Asset',
			'user' => 'User',
			'created' => 'Created',
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
		$criteria->compare('asset',$this->asset);
		$criteria->compare('user',$this->user);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Owners the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
