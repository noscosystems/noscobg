<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class EditUser extends FormModel
    {

        public $username,$priv,$old_pass,$password,$password2,$firstname,$middlename,$lastname;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('username, firstname, lastname', 'required'),
                // The database has a maximum username length of 64 characters.
                array('username', 'length','min' => 5, 'max' => 64),
                array('old_pass', 'length','min' => 5, 'max' => 60),
                array('password', 'length','min' => 5, 'max' => 60),
                array('password2', 'length','min' => 5, 'max' => 60),
                array('firstname', 'length','min' => 3, 'max' => 36),
                array('middlename', 'length','min' => 3, 'max' => 36),
                array('lastname', 'length','min' => 3, 'max' => 36),
                array('priv', 'length', 'min' => 2, 'max' => 11)
            );
        }


    }