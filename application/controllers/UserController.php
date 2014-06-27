<?php

	namespace application\controllers;

	use \Yii;
    use \CException as Exception;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\components\Form;
	use \application\models\form\Editpass;
	use \application\models\form\Register;
	use \application\models\form\Userprof;
	use \application\models\db\Users;
	use \application\models\db\Users_upd;


	class UserController extends Controller{

		public function actionRegister(){
            if (Yii::app()->user->isGuest){
            $form = new Form('application.forms.register', new Register);

            if($form->submitted() && $form->validate()) {
                // The form has been submitted and there are no errors.
                // We need to do some manual error checking, ie: check if the username is taken
                $user = Users::model()->findAllByAttributes(array('username' => $form->model->username));
                if($user){
                	//Chtml::errorSummary($form->model);
                    $form->model->addError('username', 'The username specified is already taken! Please choose another.');
                } else {
                    // Create the user.
                    $user = new Users;
                    // Assign the attributes from the form model.
                    $user->attributes = $form->model->attributes;
                    // Update the fields that are required by default.
                    // Have a basic user level of 10.
                    $user->password = \CPasswordHelper::hashPassword($user->password);
                    $user->priv = 10;
                    // Assign the branch to 1 for now, we may be using the branch field later.
                    $user->branch = 1;
                    // The created field is a unix timestamp of when the user was created.
                    $user->created = time();
                    // DOB only saves as a number, a unix timestamp.
                    $user->dob = strtotime($form->model->dob);
                    // Finally, save.
                    if(!$user->save()){
                        echo "<pre class='pre-scrollable'>"; var_dump($user->errors); echo "</pre>";
                    }
                    else{
                        Yii::app()->user->setFlash('home.register.success', 'Success!, you have successfully registered!');
                    }
                }
            }
        }
        else {
            $this->redirect(array('/home'));
        }
            $this->render('register',array('form' => $form));
        }

		// public function actionChangePass(){
		// 	$form = new Form('application.forms.edit_pass', new Editpass);
	 //            if ($form->submitted() && $form->validate()){
	 //            	$user = Users::model()->findByPk(Yii::app()->user->id);
	 //            	$old_pass = $form->model->old_pass;
	 //            	$password = $form->model->password;
	 //            	$rep_new_pass = $form->model->rep_new_pass;
	 //            	//var_dump(\CPasswordHelper::hashPassword($password));
	 //            	if ($user->password($old_pass) && $password == $rep_new_pass){
	 //            		$user->password = $password;//\CPasswordHelper::hashPassword($password);
	 //            		if (!$user->save()){
		//             		echo 'Error saving user - Line: ' . __LINE__ ;
	 //                    	echo "<br><pre class='pre-scrollable'>"; var_dump($user->errors);
	 //                    	echo "</pre>";
	 //                    	// Yii::setFlash('warning','');
	 //                	}
	 //                	else{
	 //                		Yii::app()->user->setFlash('success','Password changed successfully.');
	 //            		}
	 //            	}
	 //            }
		// 	$this->render('changepass',array('form' => $form));
		// }

	}