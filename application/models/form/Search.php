<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Search extends FormModel
    {

        public $name,$price_up,$price_dn,$area_up,$area_dn,$type,$status;

        public function rules()
        {
            return array(
                // Username and password are required.
                array('name', 'required'),
                // The database has a maximum username length of 64 characters.
				array ('name','length'),
                array('price_up', 'numerical'),
                array('price_dn', 'numerical'),
				array('area_up', 'numerical'),
                array('area_dn', 'numerical'),
                array('status', 'numerical'),
				array('type', 'numerical')
            );
        }
    }