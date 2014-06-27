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
			echo '<pre>';
			var_dump($priv= Yii::app()->user->priv);
			echo '</pre>';
			// var_dump(Yii::app()->user);
			if ((Yii::app()->user->priv)>=50){
				if (isset($_GET['id'])){
					$form = New Form('application.forms.edit_user', New EditUser);
					$user = Users::model()->findByPk($_GET['id']);
					$priv_ = $user->priv;
					$pass_ = $user->password;
					if ($form->submitted() && $form->validate()){
						if ($form->model->old_pass == ''){
							$user->attributes = $form->model->attributes;
							$user->priv = ($form->model->priv!='')?($form->model->priv):$priv_;
							$user->password = $pass_;
							$user->save();
						}
						else if (!empty($form->model->old_pass)){
							$correct = \CPasswordHelper::verifyPassword($form->model->old_pass, $user->password);
							if ($correct && $form->model->password == $form->model->password2){
								$user->attributes = $form->model->attributes;
								$user->priv = ($form->model->priv!='')?($form->model->priv):$priv_;
								$user->password = $user->_setPassword($user->password);
								$user->save();
							}
						}
					}
						// echo '<pre>';
						// var_dump($form->model->attributes);
						// echo '</pre>';
				}
			}
			else {
				// $this->redirect('/home');
			}
			$this->render ( 'index', array ( 'form' => $form, 'user' => $user ));
		}
	}