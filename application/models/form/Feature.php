<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Feature extends FormModel
    {

        public $type,$area,$desc;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('type, area, desc', 'required'),
                // The database has a maximum username length of 64 characters.
                array('type', 'length', 'max' => 30),
                array('area', 'numerical'),
                array('desc', 'length', 'max' => 256)
            );
        }


    }