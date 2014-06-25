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
			$criteria = new \CDbCriteria;
			$count = Users::model()->count($criteria);
			$pagination = new \CPagination( $count );
 			$pagination->pageSize = 2;
            $pagination->applyLimit($criteria);
			$users = Users::model()->findAll($criteria);
			$dataProvider = new CArrayDataProvider($users);
		    
			
//$actions = \application\models\db\MODEL::model()->findAll($criteria);


		    if ($form->submitted() && $form->validate()){
		    	$found_user = Users::model()->findByAttributes(array('username' => $form->model->search));
		    	$this->redirect (array('/admin/edituser', 'id' => $found_user->id));
		    }
		    $this->render('index', array('form'=>$form,
										 'pagination' => $pagination,
										 'users' => $users,
										 'dataProvider' => $dataProvider
										 )
		    );
		}
	}