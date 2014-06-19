<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Editpass extends FormModel
    {

        public $old_pass,$password,$rep_new_pass;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('old_pass, password, rep_new_pass', 'required'),
                // The database has a maximum username length of 64 characters.
                array('old_pass', 'length','min' => 5, 'max' => 60),
                array('password', 'length','min' => 5, 'max' => 60),
                array('rep_new_pass', 'length','min' => 5, 'max' => 60),
            );
        }
    }