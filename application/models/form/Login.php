<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Login extends FormModel
    {

        public $username;
        public $password;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('username, password', 'required'),
                // The database has a maximum username length of 64 characters.
                array('username', 'length','min' => 5, 'max' => 64),
                array('password', 'length','min' => 5, 'max' => 60),
            );
        }


    }
