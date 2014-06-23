<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Edit_user extends FormModel{
        public $priv;
        public function rules(){
            return array(
                // Username and password are required.
                // array('priv', 'required'),
                // array('priv', 'length','min' => 1, 'max' => 11),
            );
        }
    }