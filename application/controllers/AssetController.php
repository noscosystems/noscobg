<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Form;
    use \application\components\Controller;
    use \application\components\UserIdentity;
    use \application\models\db\Images;
    use \application\models\form\Img_upload;


    class AssetController extends Controller{

        public function actionView(){
            $form = new Form('application.forms.img_upload', new Img_upload);
            if ($form->submitted() && $form->validate()){
                $image = New Images;
                $form->model->asset = $_GET['id'];
                $image->attributes = $form->model->attributes;
                $image->image_upload( $_GET['id'], $form );
            }
            $this->render( 'view', array ('form' => $form ) );
        }

        public function actionDetails(){
            $this->render('details');
        }

    }