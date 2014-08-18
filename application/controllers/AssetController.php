<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Form;
    use \application\components\Controller;
    use \application\components\UserIdentity;
    use \application\models\db\Assets;
    use \application\models\db\Address;
    use \application\models\db\Images;
    use \application\models\form\Img_upload;
    use \application\models\form\Insert;



    class AssetController extends Controller{


        public function actionHouses(){
            $this->render( 'houses');
        }
        
        public function actionApartments(){
            $this->render( 'apartments');
        }

        public function actionLand(){
            $this->render( 'land');
        }

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

        public function actionEditAsset(){

            $asset = (isset($_GET['id']) && !empty($_GET['id']))?(Assets::model()->findByPk($_GET['id'])):'';
            if ($asset!=null){

                $form = new Form('application.forms.insert', new Insert);
                $form->model->attributes = $asset->attributes;
                $address = Address::model()->findByPk($asset->address);
                $form->model->attributes = $address->attributes;

                if($form->submitted() && $form->validate()) {

                    $asset->attributes = $form->model->attributes;
                    $address->attributes = $form->model->attributes;
                    $address->save();
                    // $asset->active = $form->model->active;
                    // $asset->status = $form->model->status;
                    $asset->owner = $form->model->owner;
                    $asset->address = $address->id;
                    $asset->active = ( $form->model->active == '' )?(1):($form->model->active);
                    ($asset->save())?(Yii::app()->user->setFlash('success','Asset updated successfully.')):'';
                    // echo '</pre>';
                }
            }
            else {
                $this->redirect(array('/admin/accoun/listassets'));
            }
            $this->render('editasset', array('form' => $form));
        }

        public function ActionImages(){

            if (isset($_GET['id']) && !empty($_GET['id'])){
                $form = new Form('application.forms.img_upload', new Img_upload);
                $asset = Assets::model()->findByPk($_GET['id']);
                $images = ($asset)?($asset->Images):'';

                if($form->submitted() && $form->validate()){
                    $image = New Images;
                    $form->model->asset = $_GET['id'];
                    $image->attributes = $form->model->attributes;
                    $image->image_upload( $_GET['id'], $form );
                }
            }
            $this->render('images', array('form' => $form, 'images' => $images));
        }

        public function ActionDeleteImage($id){

            $image = Images::model()->findByPk($id);
            ( $image->unlink_path() &&
            $image->delete() ) ?
            (Yii::app()->user->setFlash('success','Deleted image successfully.')):
            (Yii::app()->user->setFlash('warning','Something went wrong, try redeleting.'));
            $this->render('delete');
        }

        public function actionDetails($id){
            $asset = Assets::model()->findByPk($id);
            $this->render('details' , array ('asset' => $asset ) );
        }

    }