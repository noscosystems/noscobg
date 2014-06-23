<?php

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\Edit_user;
	use \application\models\db\Users;

	class ListUsersController extends Controller{

		public function actionIndex(){
			$form = New Form('application.forms.edit_user', New Edit_user);
			$users = Users::model()->findAll();
		    $this->render('index',array('form'=>$form, 'users'=>$users));
		    if ($form->submitted() && $form->validate()){
		    	foreach ($form->model->attributes as $k => $v){
		    		//echo ($k=='priv')?($v):'';
		    		echo $k;
		    	}
		    	exit;
		    	echo '<pre>';
		    	var_dump($form->model->attributes);
		    	echo '</pre>';
		    	exit;
		    	// echo '<pre>';
		    	// var_dump($users);
		    	// echo '</pre>';
		    	// exit;
		    }
		}
	}