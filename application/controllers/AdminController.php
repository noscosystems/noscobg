<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Form;
    use \application\components\Controller;
    use \application\models\form\Login;
    use \application\models\form\Register;
    use \application\models\form\Insert;
    use \application\models\db\Users;

    class AdminController extends Controller
    {

        public function actionIndex()
        { 
            $form = new Form('application.forms.insert', new Insert);
            //$this->render('index');
            $this->render('index',array('form' => $form));
           
            if(!Yii::app()->user->isGuest){
                $this->redirect(array('admin/login'));
                
            }
            
        }

        public function actionLogin(){
            $form = new Form('application.forms.login', new Login);

            if($form->submitted() && $form->validate()) {
                $user = Users::model()->findByAttributes(array('username'=>$form->model->username));
                if ($user && count($user)>0){
                    $correct = \CPasswordHelper::verifyPassword($form->model->password, $user->password);
                    if($correct) {
                        echo 'The password is correct! :)';
                        //if(!Yii::app()->user->isGuest){
                            //echo 'DA!';
                            if($user->priv >= 30){
                                // The user is an admin!
                                // $showadminPanel = true;
                                $this->actionIndex();
                                Yii::app()->user->setId($user->id);
                                //$this->redirect(array('admin/'));
                            } else {
                                // The user has only basic permissions
                                // $showAdminPanel = false;
                                $this->redirect(array('admin/login'));
                            }
                       // }
                    }
                    else {
                        echo 'The password was wrong :(';
                    }
                    // if ($user->password == $form->model->password){
                    //     echo'SUCCESS';
                    // }

                }            
            }

        $this->render('login',array('form' => $form));
        }

        public function actionRegister(){
            $form = new Form('application.forms.register', new Register);

            if($form->submitted() && $form->validate()) {
                // The form has been submitted and there are no errors.

                // We need to do some manual error checking, ie: check if the username is taken
                $user = Users::model()->findAllByAttributes(array('username' => $form->model->username));
                if($user){
                    $form->addError('username', 'The username specified is already taken! Please choose another.');
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
                    if(!$user->save()){
                        echo "<pre class='pre-scrollable'>"; var_dump($user->errors); echo "</pre>"; exit;
                    }

                    Yii::app()->user->setFlash('admin.register.success', 'Success!, you have successfully registered!');
                }
            }

            $this->render('register',array('form' => $form));
        }

    }