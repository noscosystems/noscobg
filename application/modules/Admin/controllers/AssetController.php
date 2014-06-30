<?php


    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;
    use \application\components\Form;
    use \application\models\form\Img_upload;
    use \application\models\form\Insert;
    use \application\models\form\ListUsers;
    use \application\models\db\Images;
    use \application\models\db\Address;
    use \application\models\db\Assets;

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
            }
            $criteria = new \CDbCriteria;
            $count = Assets::model()->count($criteria);
            $pages = new \CPagination( $count );
            $pages->pageSize = 10;
            $pages->applyLimit($criteria);
            $assets = Assets::model()->findAll($criteria);
            $this->render('/account/listassets');//, array('form' => $form, 'assets' => $assets,'pages' => $pages));
        }

        // public function actionEditAsset(){
        //     if(Yii::app()->user->isGuest){
        //         $this->redirect(array('/login'));
        //     }
        //     else if (Yii::app()->user->priv >=50){
        //         $form = new Form('application.forms.insert', new Insert);
        //     }
        //     else {
        //         $this->redirect(array('/home'));
        //     }

        //     if($form->submitted() && $form->validate()) {
        //     }
        //     $this->render('index',array('form' => $form, 'asset' => $asset));
        // }

    }