<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;
    use \application\components\UserIdentity;
    use \application\components\Form;
    use \application\models\form\Login;
    use \application\models\form\Register;
    use \application\models\db\Users;
    use \application\models\db\Assets;
    use \application\models\db\Address;

    class HomeController extends Controller {

        public $identity;

        public function actionIndex()
        {
            $assets = Assets::model()->findAll();

            $randAsets = [];

            $count = count($assets) -1;

            // echo '<pre>';
            // var_dump( $assets );
            // echo '</pre>'; 
            // exit;
            $randAssets = [];
            for ($i=0; $i<3; $i++){
                foreach ( $assets as $v ) {
                    $rand =  rand(0, $count);
                    if ( $rand == (int)$v->id || $i == 4 ){
                        echo "Yeaaaaaaaaaaa<br>";
                        break;
                    }
                    else
                        $randAssets[] = $assets[rand(0, $count)];
                }
           }

            echo '<pre>';
            var_dump( $randAssets );
            echo '</pre>'; 
            exit;
        
            $this->renderPartial('index', array('randAssets' => $randAssets));
        }

        public function actionLogin(){
            $form = new Form('application.forms.login', new Login);

            // Pav, I updated the login to use UserIdentity, Zander created it for our logins, as you can see, it has
            // comments. Your old code is below if you wish to compare. This basically does all the hard work for you.
            // Well, Zander has already done all the hard work for you :P Any questions on this, let me know. Luke.

            if($form->submitted() && $form->validate()) {
                // Seeing as the end-user has provided valid input data, create a new user identity with it.
                $this->identity = new UserIdentity($form->model->username, $form->model->password);
                // Do the credentials provided by the end-user's input data authenticate them as a valid user?
                if($this->identity->authenticate()) {
                    // Great! The end-user provided correct authentication credentials! Log in the user provided by the
                    // user identity created from those credentials.
                    Yii::app()->user->login($this->identity);
                    // Redirect back to where they were (defaults to the homepage if the location to return to has not
                    // been set).
                    $this->redirect(Yii::app()->user->getReturnUrl(Yii::app()->homeUrl));

                    if($user->priv >= 50){
                        // The user is an admin!
                        $this->redirect(array('admin/index'));
                    } else {
                        // The user has only basic permissions
                        $this->redirect(Yii::app()->user->getReturnUrl(Yii::app()->homeUrl));
                    }
                }
                // Unfortunately, they did not manage to pass authentication using the credentials the provided in the
                // input data.
                else {
                    // Log this failed authentication attempt.
                    Yii::log(
                        'User "' . $form->model->username . '" provided incorrect credentials.',
                        'info',
                        'application.controllers.LoginController'
                    );
                    // Grab the error code defined by UserIdentity, and add the appropriate error message to the correct
                    // model attribute (form field), so that it may be rendered by the form builder in the view.
                    switch($this->identity->errorCode) {
                        // The end-user provided a string that does not correspond to any user that we have in the
                        // database.
                        case UserIdentity::ERROR_USERNAME_INVALID:
                            $form->model->addError(
                                'username',
                                Yii::t('application', 'The username you entered does not exist.')
                            );
                            break;
                        // The end-user specified a username that is not allowed to login via the current IP address
                        // that the end-user is using.
                        case UserIdentity::ERROR_IP_INVALID:
                            $form->model->addError(
                                'username',
                                Yii::t('application', 'The username you entered may not login at this IP address.')
                            );
                            break;
                        // The end-user has made too many login attempts in a specified amount of time, inform the user
                        // to wait a while before the next attempt.
                        case UserIdentity::ERROR_THROTTLED:
                            $form->model->addError(
                                'username',
                                Yii::t('application', 'The username you entered has been throttled for security reasons. Please try again after a couple of seconds.')
                            );
                            break;
                        // The end-user has specified a password that does not match the one associated with the
                        // username the end-user provided.
                        case UserIdentity::ERROR_PASSWORD_INVALID:
                            $form->model->addError(
                                'password',
                                Yii::t('application', 'The password you entered was incorrect.')
                            );
                            break;
                    }
                }
            }

            /*

            Pav, this is your code, I updated the login to use UserIdentity, this sets all the properties needed to login etc.

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
                                Yii::app()->user->__set('username',$user->username);
                                $this->redirect(array('admin/index'));
                                // Yii::app()->user->setId($user->id);
                                // Yii::app()->user->setName($user->username);
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
            */

            $this->render('login',array(
                'form' => $form
            ));
        }

    }
