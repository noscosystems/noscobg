<?php
// Add the namespace here:
namespace application\models\db;
// Along with the correct "use"'s/
use \Yii;
use \CException;
use \application\components\ActiveRecord;
/**
 * This is the model class for table "assets".
 *
 * The followings are the available columns in table 'assets':
 * @property integer $id
 * @property string $name
 * @property double $area
 * @property integer $type
 * @property double $rent_day
 * @property double $rent_week
 * @property double $rent_month
 * @property double $price
 * @property integer $created
 * @property integer $created_by
 * @property integer $age
 * @property integer $status
 * @property string $short_desc
 * @property string $long_desc
 * @property integer $address
 * @property integer $owner
 *
 * The followings are the available model relations:
 * @property Address $address0
 * @property Users $createdBy
 * @property Option $type0
 * @property Images[] $images
 * @property Rooms[] $rooms
 */
class Assets extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'assets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, area, type, created, created_by, status, owner', 'required'),
			array('type, created, created_by, age, status, address, owner', 'numerical', 'integerOnly'=>true),
			array('area, rent_day, rent_week, rent_month, price', 'numerical'),
			array('name', 'length', 'max'=>64),
			array('short_desc', 'length', 'max'=>128),
			array('long_desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, area, type, rent_day, rent_week, rent_month, price, created, created_by, age, status, short_desc, long_desc, address, owner', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		// 'VarName'=>array('RelationType', 'ClassName', 'ForeignKey', ...additional options)

		return array(
			'Images' => array(self::HAS_MANY, '\\application\\models\\db\\Images', 'asset'),
			'Address' => array(self::HAS_ONE, '\\application\\models\\db\\Address', 'name'),
			'Option' => array(self::HAS_ONE, '\\application\\models\\db\\Option', 'id'),
			'Rooms' => array(self::HAS_MANY, '\\application\\models\\db\\Rooms', 'asset'),
			'Owner' => array(self::HAS_ONE, '\\application\\models\\db\\Users', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'area' => 'Area',
			'type' => 'Type',
			'rent_day' => 'Rent Day',
			'rent_week' => 'Rent Week',
			'rent_month' => 'Rent Month',
			'price' => 'Price',
			'created' => 'Created',
			'created_by' => 'Created By',
			'age' => 'Age',
			'status' => 'Status',
			'short_desc' => 'Short Desc',
			'long_desc' => 'Long Desc',
			'address' => 'Address',
			'owner' => 'Owner',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('area',$this->area);
		$criteria->compare('type',$this->type);
		$criteria->compare('rent_day',$this->rent_day);
		$criteria->compare('rent_week',$this->rent_week);
		$criteria->compare('rent_month',$this->rent_month);
		$criteria->compare('price',$this->price);
		$criteria->compare('created',$this->created);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('age',$this->age);
		$criteria->compare('status',$this->status);
		$criteria->compare('short_desc',$this->short_desc,true);
		$criteria->compare('long_desc',$this->long_desc,true);
		$criteria->compare('address',$this->address);
		$criteria->compare('owner',$this->owner);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Assets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
