<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Form;
    use \application\components\Controller;
    use \application\models\form\Login;

    class AdminController extends Controller
    {

        // public function actionIndex()
        // {
        //     $this->render('index');
        // }

        public function actionIndex(){
            $form = new Form('application.forms.login', new Login);

            if($form->submitted() && $form->validate()) {
                $user = \application\models\db\Users::model()->findByAttributes(array('username'=>$form->model->username));
                echo'<pre>';
                var_dump($user);
                echo '</pre>';
                if ($user && count($user)>0){
                    echo $user->username;
                    if ($user->password == $form->model->password){
                        echo'SUCCESS';
                    }
                }            
            }

        $this->render('login',array('form'=>$form));
        }
    }