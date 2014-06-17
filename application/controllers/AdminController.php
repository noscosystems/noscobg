<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Form;
    use \application\components\Controller;
    use \application\components\UserIdentity;
    use \application\models\form\Login;
    use \application\models\form\Register;
    use \application\models\form\Insert;
    use \application\models\db\Users;
    use \application\models\db\Assets;
    use \application\models\db\Address;
    use \application\models\db\Images;
    use \application\models\db\Option;
    use \application\models\db\Owners;

    class AdminController extends Controller
    {

        protected $identity;

        public function actionOwnedAssets(){
            $this->render('ownedassets');
        }

        public function actionIndex()
        {
            if(Yii::app()->user->isGuest){
                $this->redirect(array('admin/login'));
            }
            else{
                $form = new Form('application.forms.insert', new Insert);
            }
            if($form->submitted() && $form->validate()) {
                $address = New Address;
                $address->attributes = $form->model->attributes;
                $address->created = time();
                $address->save();
                //$address_name = Address::model()->findByAttributes(array('name'=> $address->name));
                $asset = New Assets;
                $asset->attributes = $form->model->attributes;
                $asset->address = $address->id;// = $address_name->id;
                $asset->created_by = Yii::app()->user->getId();
                $option = Option::model()->findByPk(1);
                $asset->type = $option->column;
                $asset->created = time();
                if ($asset->save()){
                        echo 'SUCCESS!';
                }else {
                    echo 'Oh, no, no no, Huston we got a problem !!!';
                    echo "<br><pre class='pre-scrollable'>"; var_dump($asset->errors); echo "</pre>";
                }
                $owner = New Owners;
                $owner->asset = $asset->id;
                $owner->user = $form->model->owner;
                $owner->created = time();
                $owner->save();
                // $image = New Images;
                // $image->image_upload();
            }

            $this->render('index',array('form' => $form));
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
