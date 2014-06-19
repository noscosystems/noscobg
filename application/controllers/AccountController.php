<?php

	namespace application\controllers;

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\Editpass;
	use \application\models\db\Users;


	class AccountController extends Controller
	{
		public function actionIndex()
		{
			$form = new Form('application.forms.edit_pass', new Editpass);
	            if ($form->submitted() && $form->validate()){
	            	$user = Users::model()->findByPk(Yii::app()->user->id);
	            	$old_pass = $form->model->old_pass;
	            	$password = $form->model->password;
	            	$rep_new_pass = $form->model->rep_new_pass;
	            	//var_dump(\CPasswordHelper::hashPassword($password));
	            	if ($user->password($old_pass) && $password == $rep_new_pass)
	            	{
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
			$this->render('index',array('form' => $form));
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