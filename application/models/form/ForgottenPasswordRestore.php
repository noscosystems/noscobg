<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class ForgottenPasswordRestore extends FormModel
    {

        public $new_pass,$rep_pass;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('new_pass, rep_pass', 'required'),
                // The database has a maximum username length of 64 characters.
                array('new_pass', 'length','min' => 5, 'max' => 60),
                array('rep_pass', 'length','min' => 5, 'max' => 60)
            );
        }
    }