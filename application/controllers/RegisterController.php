<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Form;
    use \application\components\Controller;
    use \application\models\form\Register;

    class RegisterController extends Controller
    {
        public function actionRegister()
        {
            $form = new Form('application.forms.register', new Register);
            //$this->render('index',array('form'=>$form));
            if($form->submitted() && $form->validated()){
                echo 'DA!';
                // Query is true.

                // You are able to set the attributes of a database model with the attributes of a form model, example:
                // Create a new empty DB model.
                $dbModel = new \application\models\db\Users;
                // Assign all attributes from the form model
                $dbModel->attributes = $form->model->attributes;
                $dbModel->branch=1;
                $dbModel->priv=10;
                $dbModel->created=time();
                // Save the database model.
                $dbModel->save();
            }
            $this->render('register',array('form'=>$form));
        // public function actionIndex(){
        //     $form = new Form('application.forms.login', new Login);

        //     if($form->submitted() && $form->validate()) {
        //         $user = \application\models\db\Users::model()->findByAttributes(array('username'=>$form->model->username));
        //         echo'<pre>';
        //         var_dump($user);
        //         echo '</pre>';
        //         if ($user && count($user)>0){
        //             echo $user->username;
        //             if ($user->password == $form->model->password){
        //                 echo'SUCCESS';
        //             }
        //         }            
        //     }

        // $this->render('login',array('form'=>$form));
        // }
    }