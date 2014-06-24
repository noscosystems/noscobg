<?php

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\ListUsers;
	use \application\models\db\Users;

	class ListUsersController extends Controller{

		public function actionIndex(){
			$form = New Form('application.forms.listusers', New ListUsers);
			$users = Users::model()->findAll();
		    
		    if ($form->submitted() && $form->validate()){
		    	$found_user = Users::model()->findByAttributes(array('username' => $form->model->search));
		    	$this->redirect (array('/admin/edituser', 'id' => $found_user->id));
		    }
		    $this->render('index',array('form'=>$form, 'users'=>$users));
		}
	}