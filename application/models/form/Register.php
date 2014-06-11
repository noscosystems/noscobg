<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Register extends FormModel
    {

        public $username;
        public $password;
        public $firstname;
        public $middlename;
        public $lastname;
        public $gender;
        public $dob;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('username, password', 'required'),
                // The database has a maximum username length of 64 characters.
                array('username', 'length','min' => 5, 'max' => 64),
                array('firstanme', 'length','min' => 5, 'max' => 36),
                array('middlename', 'length','min' => 5, 'max' => 36),
                array('lastname', 'length','min' => 5, 'max' => 36),
                array('gender', 'length','min' => 5, 'max' => 36),
                array('dob', 'length','min' => 5, 'max' => 36)
            );
        }


    }