<?php

	namespace application\controllers;

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\db\Users;
	use \application\models\form\Editpass;
	use \application\models\form\Userprof;


	class AccountController extends Controller
	{
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
					$user_search = Users::model()->findAllByAttributes(array('username' => $form->model->username));
                	if($user_search){
                    	$form->model->addError('username', 'The username specified is already taken! Please choose another.');
                	}else{
                		// $user1->dob = $user->dob;
                		// $user1->priv = $user->priv;
                		// $user1->branch = $user->branch;\
						$user->attributes = $form->model->attributes;
						if (!$user->save()){
							echo 'Error saving user - Line: ' . __LINE__ ;
	                    	echo "<br><pre class='pre-scrollable'>"; var_dump($user1->errors);
	                    	echo "</pre>";
	                    	// Yii::setFlash('warning','');
	                	}
	                	else{
	                		Yii::app()->user->setFlash('success','User profile updated successfully.');
	            		}
	            	}
				}
			}
            $this->render('myaccount',array('form' => $form, 'user'=>$user));
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