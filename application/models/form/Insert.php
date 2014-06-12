<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Insert extends FormModel
    {

        public $name,$area,$type,$created_by,$status,$short_desc,$long_desc,$address,$zip_pc,$town,$county;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('name, area, type, created_by, status, zip_pc, town, county', 'required'),
                // The database has a maximum username length of 64 characters.
                array('name', 'length','min' => 5, 'max' => 64),
                array('area', 'length','min' => 3, 'max' => 36),
                array('type', 'length','min' => 3, 'max' => 36),
                array('created_by', 'length','min' => 3, 'max' => 36),
                array('status', 'length','min' => 3, 'max' => 36),
                array('short_desc', 'length', 'max' => 128),
                array('long_desc', 'length', 'max' =>  65535),
                array('address', 'length', 'max' =>  11),
                array('zip_pc', 'length', 'min'=>5, 'max' =>  12),
                array('town', 'length', 'min'=>5, 'max' =>  64),
                array('county', 'length', 'min'=>5, 'max' =>  64)
            );
        }


    }