<?php
	
	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\EditUser;
	use \application\models\form\Register;
	use \application\models\db\Users;
	use \application\controllers\AccountController;

	class UserController extends Controller{

		public function actionIndex(){
			// var_dump(Yii::app()->user);
			if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = New Form('application.forms.edit_user', New EditUser);
            }
            else {
                $this->redirect(array('/home'));
            }
				if (isset($_GET['id']) && !empty($_GET['id'])){
					
					$user = Users::model()->findByPk($_GET['id']);
					$priv_ = $user->priv;	//buffer variable for storing the user's privilige
					$pass_ = $user->password;	//buffer variable for storing the user's password
					if ($form->submitted() && $form->validate()){
						if ($form->model->old_pass == ''){
							$user->attributes = $form->model->attributes;
							$user->priv = ($form->model->priv!='' && $user->id != Yii::app()->user->id)?($form->model->priv):$priv_;
							$user->password = $pass_;
							($user->save())?( Yii::app()->user->setFlash('success', 'Profile of user '.$user->username.' updated successfully') ):(Yii::app()->user->setFlash('warning', 'Something went wrong, please try to reedit user profile.')); 
						}
						else if (!empty($form->model->old_pass)){
							$correct = \CPasswordHelper::verifyPassword($form->model->old_pass, $user->password);
							if ($correct && $form->model->password == $form->model->password2){
								$user->attributes = $form->model->attributes;
								$user->priv = ($form->model->priv!='' && $user->id != Yii::app()->user->id)?($form->model->priv):$priv_;
								$user->password = $user->_setPassword($user->password);
								$user->save();
							}
						}
					}
						// echo '<pre>';
						// var_dump($form->model->attributes);
						// echo '</pre>';
				}
			$this->render ( 'userprofile', array ( 'form' => $form, 'user' => $user ));
		}

		public function actionCreateuser(){
			// var_dump(Yii::app()->user);
			if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.register', new Register);
            }
            else {
                $this->redirect(array('/home'));
            }
            $this->render('createuser', array ('form' => $form));
        }

        public function actionDeleteUser(){
        	if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.register', new Register);
            }
            else {
                $this->redirect(array('/home'));
            }
            // $this->render('deleteuser', array ('form' => $form));
            if (isset($_GET['id']) && !empty($_GET['id'])) {
            	$user = Users::model()->findByPk($_GET['id']);
            	($user)?(($user->delete())?(Yii::app()->user->setFlash('del_success', 'You have just deleted a user!')):''):'';
            	$this->redirect(array('/admin/listusers'));
            }
        }
	}