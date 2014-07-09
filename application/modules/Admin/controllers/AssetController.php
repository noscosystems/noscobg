<?php


    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;
    use \application\components\Form;
    use \application\models\form\Insert;
    use \application\models\form\ListUsers;
    use \application\models\form\Img_upload;
    use \application\models\db\Address;
    use \application\models\db\Assets;
    use \application\models\db\Images;


    class AssetController extends Controller{

        public $identity;

        public function actionIndex(){
            if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.insert', new Insert);
            }
            else {
                $this->redirect(array('/home'));
            }
            if($form->submitted() && $form->validate()) {
                $address = New Address;
                $address->attributes = $form->model->attributes;
                $address->created = time();
                $address->save();
                //$address_name = Address::model()->findByAttributes(array('name'=> $address->name));
                $asset = New Assets;
                $asset->attributes = $form->model->attributes;
                $asset->address = $address->id;// = $address_name->id;
                $asset->created_by = Yii::app()->user->getId();
                // The Type simply has to be the Option ID.
                $asset->type = 1;
                $asset->status = 1;
                // Assign the owner to the asset
                $asset->owner = $form->model->owner;
                $asset->created = time();
                if(!$asset->save()){
                    echo 'Error saving asset - Line: ' . __LINE__ ;
                    echo "<br><pre class='pre-scrollable'>"; var_dump($asset->errors); echo "</pre>";
                }

                /**
                No longer need to save owner like this as it is now a 1 to 1 relationship.
                */
                // $owner = New Owners;
                // $owner->asset = $asset->id;
                // $owner->user = $form->model->owner;
                // $owner->created = time();
                // if(!$owner->save()){
                //     echo 'Error saving owner - Line: ' . __LINE__ ;
                //     echo "<br><pre class='pre-scrollable'>"; var_dump($owner->errors); echo "</pre>";
                // }
                // $image = New Images;
                // $image->image_upload();

                // This will display a success message.
                Yii::app()->user->setFlash('success', 'The new Asset has been saved successfully.');
            }

            $this->render('index',array('form' => $form));
        }

        public function actionListAssets(){
            if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.listusers', new ListUsers);
            }
            else {
                $this->redirect(array('/home'));
            }

            if ($form->submitted() && $form->validate()){
               $asset = Assets::model()->findByAttributes(array ('name' => $form->model->search));
               $this->redirect (array('/admin/asset/editasset', 'id' => $asset->id));
            }
            // if ($form->submitted() && $form->validate()){
            //     $found_user = Users::model()->findByAttributes(array('username' => $form->model->search));
            //     $this->redirect (array('/admin/user', 'id' => $found_user->id));
            // }
            $criteria = new \CDbCriteria;
            $count = Assets::model()->count($criteria);
            $pages = new \CPagination( $count );
            $pages->pageSize = 10;
            $pages->applyLimit($criteria);
            $assets = Assets::model()->findAll($criteria);
            $this->render('listassets', 
                array('assets'=>$assets,
                    'form'=>$form,
                    'pages' => $pages
                ));//, array('form' => $form, 'assets' => $assets,'pages' => $pages));
        }

        public function actionEditAsset(){
            if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.insert', new Insert);
            }
            else {
                $this->redirect(array('/home'));
            }

            $asset = (isset($_GET['id']) && !empty($_GET['id']))?(Assets::model()->findByPk($_GET['id'])):'';
            if ($asset!=null){
                
                $form->model->attributes = $asset->attributes;
                $address = Address::model()->findByPk($asset->address);
                $form->model->attributes = $address->attributes;

                if($form->submitted() && $form->validate()) {

                    $asset->attributes = $form->model->attributes;
                    $address->attributes = $form->model->attributes;
                    $address->save();
                    $asset->type = 1;
                    $asset->address = $address->id;
                    // echo '<pre>';
                    ($asset->save())?(Yii::app()->user->setFlash('success','Asset updated successfully.')):'';
                    // echo '</pre>';
                }
            }
            else {
                $this->redirect(array('/admin/asset/listassets'));
            }
            $this->render('editasset', array('form' => $form));
        }

        public function ActionImages(){
            if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.insert', new Insert);
            }
            else {
                $this->redirect(array('/home'));
            }

            if (isset($_GET['id']) && !empty($_GET['id'])){
                $form = new Form('application.forms.img_upload', new Img_upload);
                $asset = Assets::model()->findByPk($_GET['id']);
                $images = ($asset)?($asset->Images):'';
            }

            // var_dump($form->model);
            // exit;

            if ($form->submitted() && $form->validate() ){
                echo 'DA!';
                exit;
                $image = New Images;
                // $form->model->asset = $_GET['id'];
                $image->attributes = $form->model->attributes;
                $image->image_upload( $_GET['id'], $form );
            }

            $this->render('images', array('images' => $images, 'form' => $form ));
        }
        public function ActionDeleteImage($id){

            if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.insert', new Insert);
            }
            else {
                $this->redirect(array('/home'));
            }

            $image = Images::model()->findByPk($id);
            ( $image->unlink_path() &&
            $image->delete() ) ?
            (Yii::app()->user->setFlash('success','Deleted image successfully.')):
            (Yii::app()->user->setFlash('warning','Something went wrong, try redeleting.'));
            $this->render('delete');
        }

    }