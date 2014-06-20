<?php
// Add the namespace here:
namespace application\models\db;
// Along with the correct "use"'s/
use \Yii;
use \CException;
use \application\components\ActiveRecord;
/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $asset
 * @property integer $created
 */
class Images extends ActiveRecord
{
	public $errors = [];
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, asset, created', 'required'),
			array('asset, created', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('url', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, url, asset, created', 'safe', 'on'=>'search'),
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
			'Assets'=>array(self::HAS_ONE, 'Images', 'asset')
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
			'url' => 'Url',
			'asset' => 'Asset',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('asset',$this->asset);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function image_upload($asset_name){
        //2 097 152 = 2MegaBytes;
        //$this->asset = $asset->id;
        //$image->asset = $asset->id;
        $allowed_img_types = Array('image/bmp','image/jpeg','image/png');
        //$mime_type = image_type_to_mime_type(exif_imagetype($_FILES['image1']['tmp_name']));
        $size = [];
        $size = getimagesize($_FILES['image1']['tmp_name']);
        if (!in_array($size['mime'],$allowed_img_types)){
            array_push($this->errors, 'Image not of allowed type. Allowed image types are jpeg, bmp and png!');
        }
        else if ($size[0]>3072){
            array_push($this->errors, 'Width is larger than 3072 pixels, please resize!');
        }
        else if ($size[1]>2304){
            array_push($this->errors, 'Height is larger than 2304 pixels, please resize!');
        }
        else if ($_FILES['image1']['size']>2097152){
            array_push($this->errors, 'Size is greater than 2MBs, please upload a smaller image!');
        }
        else{
            $this->name = $_FILES['image1']['name'];
            $folder = Yii::getPathOfAlias('application.views.Uploads').'\\'.$asset_name.'\\';/*Yii::getPathOfAlias("application.themes.classic.assets.images")*/
            ( !file_exists($folder) )?(mkdir ($folder, true) ):'';
            $this->url = $folder.$_FILES['image1']['name'];
            $this->created = time();
            if ( !move_uploaded_file($_FILES['image1']['tmp_name'], $folder.'/'.$_FILES['image1']['name']) ){
            	array_push($this->errors, 'Unable to upload image, please try again!');
            }
        }
        if (empty($this->errors)){
        	echo ($this->save())?'YESSSSS!!!!':'Noooooooooo!';
        }
        else {
        	echo "<pre class='pre-scrollable'>"; var_dump($this->errors); echo "</pre>";
        	return false;
        }
    }
}
