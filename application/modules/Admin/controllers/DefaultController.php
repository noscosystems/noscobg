<?php

	use \Yii;
    use \CException as Exception;
	use \application\components\Form;
	use \application\components\Controller;
	use \application\components\UserIdentity;
	use \application\models\form\Editpass;
	use \application\models\db\Users;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
