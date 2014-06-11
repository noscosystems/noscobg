<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Insert extends FormModel
    {

        public $name;
        public $area;
        public $type;
        public $created_by;
        public $status;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('name, area, type, created_by, status', 'required'),
                // The database has a maximum username length of 64 characters.
                array('name', 'length','min' => 5, 'max' => 64),
                array('area', 'length','min' => 3, 'max' => 36),
                array('type', 'length','min' => 3, 'max' => 36),
                array('created_by', 'length','min' => 3, 'max' => 36),
                array('status', 'length','min' => 3, 'max' => 36)
            );
        }


    }