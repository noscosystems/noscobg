<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Room extends FormModel
    {

        public $type,$area,$desc;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('type, area, desc', 'required'),
                // The database has a maximum username length of 64 characters.
                array('type', 'numerical', 'integerOnly' => true, 'max' => 11),
                array('area', 'numerical'),
                array('desc', 'length', 'max' => 256)
            );
        }


    }