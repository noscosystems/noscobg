<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $title
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property integer $priv
 * @property integer $dob
 * @property integer $gender
 * @property integer $branch
 * @property integer $created
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Assets[] $assets
 * @property Rooms[] $rooms
 * @property Option $title0
 */
namespace application\models\db;

use \Yii;
use \CException;
use \application\components\ActiveRecord;

class Users extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, firstname, lastname, priv, dob, gender, branch, created', 'required'),
			array('title, priv, dob, gender, branch, created, active', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>64),
			array('password', 'length', 'max'=>60),
			array('firstname, middlename, lastname', 'length', 'max'=>36),
			array('email', 'length', 'max'=>128),
			array('mobile_number', 'length', 'max'=>15),
			// array('mobile_number', 'unique', 'className' => '\\application\\models\\db\\Users', 'attributeName' => 'mobile_number', 'message' => 'Mobile number already taken by another user.'),
			// array('email', 'unique', 'className' => '\\application\\models\\db\\Users', 'attributeName' => 'email', 'message' => 'Email already taken by another user.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, title, firstname, middlename, lastname, priv, dob, gender, branch, created, active', 'safe', 'on'=>'search'),
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
			'Assets' => array(self::HAS_MANY, '\\application\\models\\db\\Assets', 'owner'),
			'OwnedAssets' => array(self::HAS_MANY, '\\application\\models\\db\\Owners', '{{owners}}(user, asset)', 'order' => 'Assets.id DESC'),
			'Rooms' => array(self::HAS_MANY, '\\application\\models\\db\\Rooms', 'created_by'),
			'Title' => array(self::BELONGS_TO, '\\application\\models\\db\\Option', 'title'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'title' => 'Title',
			'firstname' => 'Firstname',
			'middlename' => 'Middlename',
			'lastname' => 'Lastname',
			'priv' => 'Priv',
			'dob' => 'Dob',
			'gender' => 'Gender',
			'branch' => 'Branch',
			'created' => 'Created',
			'active' => 'Active',
			'email' => 'Email',
			'mobile_number' => 'Mobile_number',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('title',$this->title);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('middlename',$this->middlename,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('priv',$this->priv);
		$criteria->compare('dob',$this->dob);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('branch',$this->branch);
		$criteria->compare('created',$this->created);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



    /**
     * Full Name
     *
     * @access public
     * @return string
     */
    public function getFullName()
    {
        if(!is_null($this->fullName)) {
            return $this->fullName;
        }
        $this->fullName = ucwords($this->firstname) . ' ' . ucwords($this->lastname);
        return $this->fullName;
    }


    /* -------------------------------- *\
    |  END:   NAMING METHODS             |
    |  BEGIN: PASSWORD-SPECIFIC METHODS  |
    \* -------------------------------- */


    /**
     * Check Password
     *
     * Check that the password supplied to this method equates to the same password hash that is stored in the
     * database for the user identified by the current (this) model instance.
     *
     * @access public
     * @param string $password
     * @return boolean
     */
    public function password($password)
    {
        return \CPasswordHelper::verifyPassword($password, $this->password);
    }


    /**
     * PHP Magic Function: Set
     *
     * Override the method to extend the functionality (hash a password that is set as an attribute before adding it
     * to the model).
     *
     * @access public
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($property, $value)
    {
        // If an override method exists for a certain property, call it to alter the value before passing it to the
        // model to be saved to the database.
        $method = 'set' . ucwords($property);
        if(method_exists($this, $method)) {
            $value = $this->{$method}($value);
        }
        // Carry on setting it to the model as normal.
        parent::__set($property, $value);
    }


    /**
     * Set: Password
     *
     * @access protected
     * @param string $password
     * @return void
     */
    public function _setPassword($password)
    {
        return \CPasswordHelper::hashPassword($password);
    }
}
