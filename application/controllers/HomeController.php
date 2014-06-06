<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;

    class HomeController extends Controller
    {

        public function actionIndex()
        {
            $this->renderPartial('index');
        }

    }
