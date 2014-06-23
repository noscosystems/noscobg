<?php

namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Userprof extends FormModel
    {

        public $username;
        public $firstname;
        public $middlename;
        public $lastname;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('username, firstname, lastname', 'required'),
                // The database has a maximum username length of 64 characters.
                array('username', 'length','min' => 5, 'max' => 64),
                array('firstname', 'length','min' => 3, 'max' => 36),
                array('middlename', 'length','min' => 3, 'max' => 36),
                array('lastname', 'length','min' => 3, 'max' => 36)
            );
        }
    }