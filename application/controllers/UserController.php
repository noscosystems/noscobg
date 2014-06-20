<?php

	namespace application\controllers;

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\Editpass;
	use \application\models\db\Users;


	class UserController extends Controller{
		public function actionChangePass(){
			$form = new Form('application.forms.edit_pass', new Editpass);
	            if ($form->submitted() && $form->validate()){
	            	$user = Users::model()->findByPk(Yii::app()->user->id);
	            	$old_pass = $form->model->old_pass;
	            	$password = $form->model->password;
	            	$rep_new_pass = $form->model->rep_new_pass;
	            	//var_dump(\CPasswordHelper::hashPassword($password));
	            	if ($user->password($old_pass) && $password == $rep_new_pass){
	            		$user->password = $password;//\CPasswordHelper::hashPassword($password);
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

		function actionLogout(){
		    Yii::app()->user->logout();
		    $this->render('logout');
		}

		public function actionListAssets(){
            $this->render('listassets');
        }

		public function actionMyaccount(){
            $this->render('myaccount');
        }
	}