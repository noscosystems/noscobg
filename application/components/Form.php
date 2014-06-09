<?php

    namespace application\components;

    use \Yii;
    use \CException;

    /**
     * Form Builder
     *
     * @author      Zander Baldwin <mynameiszanders@gmail.com>
     * @link        https://github.com/mynameiszanders/yii-forms
     * @copyright   2013 Zander Baldwin
     * @license     MIT/X11 <http://j.mp/license>
     * @package     application.components
     */
    class Form extends \CForm
    {

        /**
         * Constructor Method
         *
         * @access public
         * @param string|array $config
         * @param CModel $model
         * @param CBaseController|CForm $parent
         * @return void
         */
        public function __construct($config, $model = null, $parent = null)
        {
            parent::__construct($config, $model, $parent);
            // Change the default active form widget class from "CActiveForm" to "\application\components\ActiveForm".
            if(!is_array($this->activeForm) || !isset($this->activeForm['class']) || $this->activeForm['class'] == 'CActiveForm') {
                $activeFormClass = array('class' => '\\application\\components\\ActiveForm');
                $this->activeForm = is_array($this->activeForm)
                    ? \CMap::mergeArray($this->activeForm, $activeFormClass)
                    : $activeFormClass;
            }
            // Are there any events to attach?
            \application\components\EventManager::attach($this);
        }

        /**
         * Is Form Submitted?
         *
         * @access public
         * @param string $buttonName
         * @param boolean $loadData
         * @return boolean
         */
        public function submitted($buttonName = null, $loadData = true)
        {
            // Has the hidden field been submitted?
            if($this->clicked($this->getUniqueId())) {
                // Are we looking for a specific button click, or do we just want to know if any button was clicked to
                // submit the form?
                $buttons = is_string($buttonName)
                    ? array($buttonName)
                    : $this->buttons->keys;
                // Iterate over the button names, regardless of what was specified.
                foreach($buttons as $buttonName) {
                    // Has the button been clicked?
                    if($this->clicked($buttonName)) {
                        // The button has been clicked! Before we return true, do we need to load the data into the
                        // model associated with this form?
                        $loadData && $this->loadData();
                        // Return true.
                        return true;
                    }
                }
                // We exhausted our list of buttons, and none of them were clicked. Continue and return the same value
                // as no hidden field.
            }
            // Uh-oh, looks like the hidden field wasn't submitted. Probably being spammed... Return false.
            return false;
        }

    }
