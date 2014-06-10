<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Form;
    use \application\components\Controller;
    use \application\models\form\Login;
    use \application\models\form\Register;
    use \application\models\db\Users;

    class AdminController extends Controller
    {

        public function actionIndex()
        {
            $this->render('index');
        }

        public function actionLogin(){
            $form = new Form('application.forms.login', new Login);

            if($form->submitted() && $form->validate()) {
                $user = Users::model()->findByAttributes(array('username'=>$form->model->username));
                if ($user && count($user)>0){
                    $correct = \CPasswordHelper::verifyPassword($form->model->password, $user->password);
                    if($correct) {
                        echo 'The password is correct! :)';
                        if(!Yii::app()->user->isGuest){
                            if(Yii::app()->user->priv >= 50){
                                // The user is an admin!
                                $showadminPanel = true;
                            } else {
                                // The user has only basic permissions
                                $showAdminPanel = false;
                            }
                        }
                    }
                    else {
                        echo 'The password was wrong :(';
                    }
                    // if ($user->password == $form->model->password){
                    //     echo'SUCCESS';
                    // }

                }            
            }

        $this->render('login',array('form'=>$form));
        }

        public function actionRegister(){
            $form = new Form('application.forms.register', new Register);
            $this->render('register',array('form'=>$form));
        }

    }