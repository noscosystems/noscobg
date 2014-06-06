<?php

    namespace application\controllers;

    use \Yii;
    use \CException as Exception;
    use \application\components\Controller;

    class HelpController extends Controller
    {

        public function actionIndex()
        {
            $this->render('index');
        }


        public function actionSearch($search)
        {
            // $_GET['search'] == $search;
            if($search !== "" && strlen($search) > 3){
                // Do stuff
            }

            $this->renderPartial('search', array(
                'search' => $search,
            ));
        }

    }
