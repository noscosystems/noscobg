<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Insert extends FormModel
    {

        public $name,$area,$type,$owner,$status,$age,$price,$short_desc,$long_desc,$active,$rent_day,$rent_week,$rent_month,
        $address,$zip_pc,$town,$street,$district,$county,$country,$number,$flat;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('name, area, type, status, zip_pc, town, owner, county', 'required'),
                // The database has a maximum username length of 64 characters.
                array('name', 'length','min' => 5, 'max' => 64),
                array('area', 'length','min' => 3, 'max' => 36),
                //array('created_by', 'length','min' => 1, 'max' => 36),
                array('short_desc', 'length', 'max' => 128),
                array('long_desc', 'length', 'max' =>  65535),
                array('price', 'length'),
                array('age', 'length', 'max' =>  64),
                array('rent_day', 'length'),
                array('rent_week', 'length'),
                array('rent_month', 'length'),
                array('address', 'length', 'max' =>  11),
                array('zip_pc', 'length', 'min'=>4, 'max' =>  12),
                array('town', 'length', 'min'=>3, 'max' =>  64),
                array('district', 'length', 'min'=>5, 'max' =>  64),
                array('street', 'length', 'min'=>2, 'max' =>  64),
                array('county', 'length', 'min'=>2, 'max' =>  64),
                array('country', 'length', 'min'=>2, 'max' =>  64),
                array('number', 'length', 'max' =>  11),
                array('flat', 'length', 'max' =>  11),
                array('active', 'boolean'),
                array('status', 'numerical')
            );
        }


    }