<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;

    class AdminController extends Controller
    {

        public function actionIndex()
        {
            $this->render('index');
        }

    }