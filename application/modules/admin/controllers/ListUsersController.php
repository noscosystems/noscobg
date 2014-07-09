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
			if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = New Form('application.forms.listusers', New ListUsers);
            }
            else {
                $this->redirect(array('/home'));
            }
			
			$criteria = new \CDbCriteria;
			$count = Users::model()->count($criteria);
			$pages = new \CPagination( $count );
 			$pages->pageSize = 10;
            $pages->applyLimit($criteria);
			$users = Users::model()->findAll($criteria);
			//$dataProvider = new CArrayDataProvider($users);
		    
			
//$actions = \application\models\db\MODEL::model()->findAll($criteria);


		    if ($form->submitted() && $form->validate()){
		    	$found_user = Users::model()->findByAttributes(array('username' => $form->model->search));
		    	$this->redirect (array('/admin/user', 'id' => $found_user->id));
		    }
		    $this->render('index', array('form'=>$form,
										 'pages' => $pages,
										 'users' => $users
										 )
		    );
		}
	}