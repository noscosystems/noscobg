<?php
	
	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\EditUser;
    use \application\models\form\ListUsers;
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
            if ($form->submitted() && $form->validate()){
            	$user = Users::model()->findAllByAttributes(array('username' => $form->model->username));
                if($user){
                	//Chtml::errorSummary($form->model);
                    $form->model->addError('username', 'The username specified is already taken! Please choose another.');
                } else {
                    // Create the user.
                    $user = new Users;
                    // Assign the attributes from the form model.
                    $user->attributes = $form->model->attributes;
                    // Update the fields that are required by default.
                    // Have a basic user level of 10.
                    $user->password = \CPasswordHelper::hashPassword($user->password);
                    $user->priv = 10;
                    // Assign the branch to 1 for now, we may be using the branch field later.
                    $user->branch = 1;
                    // The created field is a unix timestamp of when the user was created.
                    $user->created = time();
                    // DOB only saves as a number, a unix timestamp.
                    $user->dob = strtotime($form->model->dob);
                    // Finally, save.
                    $user->email = (empty($form->model->email))?(null):'';
                    $user->mobile_number = (empty($form->model->mobile_number))?(null):'';
                    if(!$user->save()){
                        echo "<pre class='pre-scrollable'>"; var_dump($user->errors); echo "</pre>";
                    }
                    else{
                        Yii::app()->user->setFlash('success', 'Success!, you have successfully created a user!');
                    }
                }
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
                $assets = $user->Assets;
            	($user && empty ($assets))
                    ?(($user->delete())
                        ?(Yii::app()->user->setFlash('del_success', 'You have just deleted a user!'))
                        :(Yii::app()->user->setFlash('del_failed', 'User owns assets!')))
                    :'';
            	$this->redirect(array('/admin/listusers'));
            }
        }

        public function actionListUsers(){
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
            $this->render('listusers', array('form'=>$form,
                                         'pages' => $pages,
                                         'users' => $users
                                         )
            );
        }
	}