<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;
    use \application\components\UserIdentity;
    use \application\components\Form;
    use \application\models\form\Login;
    use \application\models\form\Register;
	use \application\models\form\Search;
    use \application\models\db\Users;
    use \application\models\db\Assets;
    use \application\models\db\Address;

    class HomeController extends Controller {

        public $identity;

        public function actionIndex()
        {
			$form = new Form('application.forms.search', new Search);

            if ($form->submitted() && $form->validate()){
                $frm = $form->model;
                if ( $frm->price_up < $frm->price_dn ) {
                    $frm->addError ('price range', 'Minimal price is greater than maximum price.');
                }
                if ( $frm->area_up < $frm->area_dn ) {
                    $frm->addError ('area range', 'Minimal area is greater than maximum area.');
                }

                $sql = "SELECT * FROM assets WHERE
                            type ".(($frm->type=='')?("!="):("=")).":type        
                            AND
                            status ".(($frm->status=='')?("!="):("="))." :status
                            AND
                            price BETWEEN 
                            :price_dn
                            AND
                            :price_up
                            AND area BETWEEN
                            :area_dn
                            AND
                            :area_up
                        ORDER BY 
                            price DESC
                ";

                if(!$form->model->area_up)
                    $form->model->area_up = 9999999999999999;

                if(!$form->model->area_dn)
                    $form->model->area_dn = 1;

                if(!$form->model->area_up)
                    $form->model->area_up = 1;

                if(!$form->model->price_up)
                    $form->model->price_up = 9999999999999999;

                if(!$form->model->price_dn)
                    $form->model->price_dn = 1;

                if(!$form->model->price_up)
                    $form->model->price_up = 1;

                $assets = Assets::model()->findAllBySql($sql, array(
                    ':type' => $frm->type,
                    ':status' => $frm->status,
                    ':price_up' => $frm->price_up,
                    ':price_dn' => $frm->price_dn,
                    ':area_up' => $frm->area_up,
                    ':area_dn' => $frm->area_dn
                ));
                
                    // $assets[] = $assets_obj;
                
            }else {
                // $sql = "SELECT * FROM `assets` LIMIT 0,10";

                $assets_db = Assets::model()->findAll();

                if ( isset($assets_db) && !empty($assets_db) && count($assets_db)>=3 ){

                    $count = count($assets_db) -1;

                    $assets = [];
                    $rands = [];
                    $i=0;
                    do {

                        $rand = rand(1,$count);

                        if ( !in_array($rand = rand(0,$count), $rands) ){
                            array_push( $rands, $rand );
                            $i++;
                        }

                    }while ($i<3);

                    for ($j=0; $j<count($rands);  $j++){
                        $assets[] = $assets_db[$rands[$j]];
                    }
                }else{
                    $assets = 'No assets yet.';
                }
            }
            $this->renderPartial('index', array ('form' => $form, 'assets' => $assets));
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

            $this->render('login',array(
                'form' => $form
            ));
        }
        public function actionAboutUs()
        {
            $this->render('AboutUs');
        }

    }
