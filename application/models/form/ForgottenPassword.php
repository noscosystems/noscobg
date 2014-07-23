<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class ForgottenPassword extends FormModel
    {

        public $username,$email;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('username, email', 'required'),
                // The database has a maximum username length of 64 characters.
                array('username', 'length','min' => 5, 'max' => 64),
                array('email', 'length','min' => 5, 'max' => 128),
            );
        }


    }