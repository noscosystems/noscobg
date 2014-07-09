<?php

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\Insert;
	use \application\models\db\Users;
	use \application\models\db\Address;
	use \application\models\db\Assets;

class DefaultController extends Controller
{
	public $identity;

        public function actionIndex(){
            if(Yii::app()->user->isGuest){
                $this->redirect(array('/login'));
            }
            else if (Yii::app()->user->priv >=50){
                $form = new Form('application.forms.insert', new Insert);
            }
            else {
                $this->redirect(array('/home'));
            }
            $this->render('index');
        }

       //  public function actionListUsers(){
       //     $users = Users::model()->findbyAll();
       //     var_dump($users);
       //     $this->render('listusers');//,array('users'=>$users));
       // }
}
