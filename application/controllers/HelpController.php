<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;

    class HelpController extends Controller
    {

        // This function demonstrates how to display a view
        public function actionIndex()
        {
            $this->render('index');
        }

        // This function demonstrates how you would use a $_GET parameter
        public function actionSearch($search)
        {
            // $_GET['search'] == $search;
            if($search !== "" && strlen($search) > 3){
                // Do stuff
            }

            $this->renderPartial('search', array(
                'search' => $search,
            ));
        }

        // This functon demonstrates how to use forms
        public function actionForm()
        {
            // Construct a new Form.
            // Replace 'config' with the form configuration and 'Model' with the form model (see later).
            // See \application\forms for the configs.
            // See \application\models\form for the form models.
            $form = new Form('application.forms.config', new \application\models\form\Model);

            // Check if the form has been submitted and validated.
            if($form->submitted() && $form->validated()){
                // Query is true.

                // You are able to set the attributes of a database model with the attributes of a form model, example:
                // Create a new empty DB model.
                $dbModel = new \application\models\db\Users;
                // Assign all attributes from the form model
                $dbModel->attributes = $form->model->attributes;
                // Save the database model.
                $dbModel->save();
                // Any attributes with the same name will be matched and updated.

                // You are able to modify the data of the form:
                $form->model->username = "Scowen";

                // You are able to modify multiple attributes using an array:
                $form->model->attributes = array(
                    'username' => 'Scowen',
                    'password' => '$uP3r$3Cur3',
                );
                // The same can be done with database model assignments:
                $dbModel->attributes = array(
                    'username' => $form->model->username,
                    'password' => $form->model->password,
                );

                // End of form onSubmit
            }

            // There is no view named 'form'.
            $this->render('form', array(
                'form' => 'form',
            ));
        }

        // This function will demonstrate how to use some of the user functions.
        public function actionUser()
        {
            // If I wanted to check if the user was logged in:
            if(!Yii::app()->user->isGuest){
                // User is logged in
                // Lets check if they have an admin level
                if(Yii::app()->user->priv >= 50){
                    // The user is an admin!
                    $showAdminPanel = true;
                } else {
                    // The user has only basic permissions
                    $showAdminPanel = false;
                }

                // Lets display the username!
                echo Yii::app()->user->model()->username;

                // Lets get all the Assets that this user has created. Using a relation!
                $assets = Yii::app()->user->model()->Assets;

                // I don't like typing that long string every time I want to access the user model, lets assign it.
                $user = Yii::app()->user->model();

                // That's better, now lets see if the user owns any assets.
                if($user->OwnedAssets && is_array($user->OwnedAssets) && count($user->OwnedAssets) > 0){
                    // The user has some assets! Lets go through them.
                    foreach($user->OwnedAssets as $asset){
                        echo $asset->id;
                        echo $asset->name;
                    }
                } else {
                    // The user has no assets :(
                }
            } else {
                // The user is a guest, get them to log in by force!
                $this->redirect(array('/login'));
            }
        }

    }
