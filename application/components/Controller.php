<?php

    namespace application\components;

    use \Yii;
    use \CException;

    /**
     * Controller
     *
     * Controller is the customized base controller class. All controller classes for this application should extend
     * from this base class.
     */
    abstract class Controller extends \CController
    {

        /**
         * @access public
         * @var string $layout
         * The default layout for the controller view.
         */
        public $layout = '//layouts/column1';

        /**
         * @access public
         * @var array $menu
         * Context menu items. This property will be assigned to CMenu::items.
         */
        public $menu = array();

        /**
         * @access public
         * @var array $breadcrumbs
         * The breadcrumbs of the current page. The value of this property will be assigned to CBreadcrumbs::links.
         */
        public $breadcrumbs = array();

        /**
         * @access protected
         * @var \application\models\db\Document $document
         * The ActiveRecord model for the document that will attempted to be forced on the end-user.
         */
        protected $document;

        /**
         * Get: Download Document
         *
         * @access public
         * @return \application\models\db\Document
         */
        public function getDownloadDocument()
        {
            return $this->document;
        }


        /**
         * Set: Download Document
         *
         * @access public
         * @param integer|Document $document
         * @return void
         */
        public function setDownloadDocument($document)
        {
            $document = $document instanceof \application\models\db\Document && !$document->isNewRecord
                ? $document
                : \application\models\db\Document::model()->findByPk($document);
            if($document !== null) {
                $this->document = $document;
            }
        }


        /**
         * Has: Download Document
         *
         * @access public
         * @return boolean
         */
        public function hasDownloadDocument()
        {
            return $this->document !== null;
        }


        /**
         * Filter: Access Control
         *
         * @access public
         * @param CFilterChain $filterChain
         * @return void
         */
        public function filterAccessControl($filterChain)
        {
            // Make sure that the accessRules() method returns an array; we don't need to check if it exists because
            // it's defined in CController.
            if(!is_array($rules = $this->accessRules())) {
                return;
            }
            // Create a new instance of the custom AccessControlFilter class.
            $filter = new AccessControlFilter;
            // Assign to it the rules defined in the Controller.
            $filter->setRules($rules);
            // Run the filter and the rest in the chain.
            $filter->filter($filterChain);
        }

    }
