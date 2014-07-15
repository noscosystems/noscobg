<?php

	namespace application\controllers;

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\db\Users;
	use \application\models\form\Register;
	use \application\models\form\Editpass;
	use \application\models\form\Userprof;


	class AccountController extends Controller{

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
                    $sql = 'SELECT *
							    FROM `users`
							    WHERE `id`!=:id AND `email`=:email';
						$sql1 = 'SELECT *
							    FROM `users`
							    WHERE `id`!=:id AND `mobile_number`=:mobile_number';
						$users = Users::model()->findAllBySql($sql,
							array(
								':id' => (int)Yii::app()->user->id,
								':email' => (string)$form->model->email
								/*':mobile_number' => ($form->model->mobile_number)*/
								)
							);
					$user->email = (empty($form->model->email))?(null):(($user->email === $form->model->email)?($user->email):'');
					$user->mobile_number = (empty($form->model->mobile_number))?(null):(($user->mobile_number === $form->model->mobile_number)?($user->mobile_number):'');
						// $users = Users::model()->findAllByAttributes(array('mobile_number' => $form->model->mobile_number));
						if ($users){
							$form->model->addError('email','This Email is already taken.');
						}
						if ($users = Users::model()->findAllBySql($sql1, array(
								':id' => (int)Yii::app()->user->id,
								':mobile_number' => (string)$form->model->mobile_number
								))) {
							$form->model->addError('mobile_number','Mobile number already taken by another user.');
						}
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
                    (empty($form->model->errors))?($user->save()?(Yii::app()->user->setFlash('success','Registered successfully.')):''):'';
                }
            }
        }
        else {
            $this->redirect(array('/home'));
        }
            $this->render('register',array('form' => $form));
        }

		public function actionChangePass()
		{
			$form = new Form('application.forms.edit_pass', new Editpass);
	            if ($form->submitted() && $form->validate()){
	            	$user = Users::model()->findByPk(Yii::app()->user->id);
	            	$old_pass = $form->model->old_pass;
	            	$password = $form->model->password;
	            	$rep_new_pass = $form->model->rep_new_pass;
	            	//var_dump(\CPasswordHelper::hashPassword($password));
	            	if ($user->password($old_pass) && $password == $rep_new_pass){
	            		$user->password = Users::model()->_setPassword($rep_new_pass);//\CPasswordHelper::hashPassword($password);
	            		if (!$user->save()){
		            		echo 'Error saving user - Line: ' . __LINE__ ;
	                    	echo "<br><pre class='pre-scrollable'>"; var_dump($user->errors);
	                    	echo "</pre>";
	                    	// Yii::setFlash('warning','');
                    	}
                    	else{
                    		Yii::app()->user->setFlash('success','Password changed successfully.');
	            		}
	            	}
	            }
			$this->render('changepass',array('form' => $form));
		}

		public function actionMyaccount(){
			if (!Yii::app()->user->isGuest){
				$form = new Form('application.forms.userprof', new Userprof);
				$user = Users::model()->findbyPk(Yii::app()->user->id);
				if ($form->submitted() && $form->validate()){
						$sql = 'SELECT *
							    FROM `users`
							    WHERE `id`!=:id AND `email`=:email';
						$sql1 = 'SELECT *
							    FROM `users`
							    WHERE `id`!=:id AND `mobile_number`=:mobile_number';
						$users = Users::model()->findAllBySql($sql,
							array(
								':id' => (int)Yii::app()->user->id,
								':email' => (string)$form->model->email
								/*':mobile_number' => ($form->model->mobile_number)*/
								)
							);
						// $users = Users::model()->findAllByAttributes(array('mobile_number' => $form->model->mobile_number));
						if ($users){
							$form->model->addError('email','This Email is already taken.');
						}
						if ($users = Users::model()->findAllBySql($sql1, array(
								':id' => (int)Yii::app()->user->id,
								':mobile_number' => (string)$form->model->mobile_number
								))) {
							$form->model->addError('mobile_number','Mobile number already taken by another user.');
						}
						$user->attributes = $form->model->attributes;
						$user->email = (empty($form->model->email))?(null):(($user->email === $form->model->email)?($user->email):'');
						$user->mobile_number = (empty($form->model->mobile_number))?(null):(($user->mobile_number === $form->model->mobile_number)?($user->mobile_number):'');
						(empty($form->model->errors))?($user->save()?(Yii::app()->user->setFlash('success','User profile updated successfully.')):''):'';
						// if (!$user->save()){
						// 	foreach ($user->errors as $k => $v){
						// 		$form->model->addError($k, $v);
						// 	}
							// echo 'Error saving user - Line: ' . __LINE__ ;
	      //               	echo "<br><pre class='pre-scrollable'>"; var_dump($user->errors['mobile_number'][0]);
	      //               	echo "</pre>";
	          //           	(!empty($user->errors['email'][0]))?Yii::app()->user->setFlash('account.myaccount.warning1',$user->errors['email'][0]):'';
	     					// (!empty($user->errors['mobile_number'][0]))?Yii::app()->user->setFlash('account.myaccount.warning',$user->errors['mobile_number'][0]):'';
	     //                	Yii::app()->setFlash('warning',$users->errors);
	     //                	Yii::app()->user->setFlash('User saving errors',$user->erros);
							// exit;
	                	// }
	                	// ($user->save())?(Yii::app()->user->setFlash('success','User profile updated successfully.')):'';
	              //   	else{
	              //   		Yii::app()->user->setFlash('success','User profile updated successfully.');
	            		// }
	            	// }
				}
			}
            $this->render('myaccount',array('form' => $form, 'user'=>$user));
        }

        public function actionListAssets(){
            $this->render('listassets');
        }

		function actionLogout(){
		    // (Yii::app()->user->logout())?(Yii::app()->user->setFlash('account.logout.success', 'Successfully logged out. Hope to see you soon, again.')):'';
		    Yii::app()->user->logout();
		    Yii::app()->user->setFlash('account.logout.success', 'Successfully logged out. Hope to see you soon, again.');
		    $this->render('logout');
		}


		// Uncomment the following methods and override them if needed
		/*
		public function filters()
		{
			// return the filter configuration for this controller, e.g.:
			return array(
				'inlineFilterName',
				array(
					'class'=>'path.to.FilterClass',
					'propertyName'=>'propertyValue',
				),
			);
		}

		public function actions()
		{
			// return external action classes, e.g.:
			return array(
				'action1'=>'path.to.ActionClass',
				'action2'=>array(
					'class'=>'path.to.AnotherActionClass',
					'propertyName'=>'propertyValue',
				),
			);
		}
		*/
	}