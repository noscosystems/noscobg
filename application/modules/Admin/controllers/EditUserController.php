<?php
	
	

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\EditUser;
	use \application\models\db\Users;

	class EditUserController extends Controller{

		public function actionIndex(){
			if (isset($_GET['id'])){
				$form = New Form('application.forms.edit_user', New EditUser);
				$user = Users::model()->findByPk($_GET['id']);
				if ($form->submitted() && $form->validate()){
					echo '<pre>';
					var_dump($form->model->attributes);
					echo '</pre>';
				}
			}
			
			$this->render ( 'index', array ( 'form' => $form, 'user' => $user ));
		}
	}