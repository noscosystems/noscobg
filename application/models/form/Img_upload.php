<?php

    namespace application\models\form;

    use \Yii;
    use \CException;
    use \application\components\FormModel;

    class Img_upload extends FormModel
    {
    	public $asset;
    	public function rules()
        {
			return array(
					array('asset', 'required'),
                	array('asset', 'length','min' => 1, 'max' => 11)
                   );
        }

    }