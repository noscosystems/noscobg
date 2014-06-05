<?php
// Add the namespace here:
namespace application\models\db;
// Along with the correct "use"'s/
use \Yii;
use \CException;
use \application\components\ActiveRecord;

/**
 * This is the model class for table "address".
 *
 * The followings are the available columns in table 'address':
 * @property integer $id
 * @property integer $number
 * @property string $name
 * @property integer $flat
 * @property string $zip_pc
 * @property string $discrict
 * @property string $town
 * @property string $street
 * @property string $country
 * @property string $county
 * @property integer $created
 */
class Address extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zip_pc, town, county, created', 'required' ),
			array('number, flat, created', 'numerical', 'integerOnly'=>true),
			array('name, discrict, town, street, country, county', 'length', 'max'=>64),
			array('zip_pc', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, name, flat, zip_pc, discrict, town, street, country, county, created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'name' => 'Name',
			'flat' => 'Flat',
			'zip_pc' => 'Zip Pc',
			'discrict' => 'Discrict',
			'town' => 'Town',
			'street' => 'Street',
			'country' => 'Country',
			'county' => 'County',
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
		$criteria->compare('number',$this->number);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('flat',$this->flat);
		$criteria->compare('zip_pc',$this->zip_pc,true);
		$criteria->compare('discrict',$this->discrict,true);
		$criteria->compare('town',$this->town,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('county',$this->county,true);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Address the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
