<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;
    use \application\components\Form;
    use \application\models\form\Img_upload;
    use \application\models\db\Images;

    class AssetController extends Controller{
        public function actionView(){
            $form = new Form('application.forms.img_upload', new Img_upload);
            if ($form->submitted() && $form->validate()){
                $image = New Images;
                $form->model->asset = $_GET['id'];
                $image->attributes = $form->model->attributes;
                $image->image_upload($_GET['asset_name']);
            }
            //$this->render('ownedassets');
            $this->render('view',array('form' => $form));
        }

    }