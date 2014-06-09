<?php

    namespace application\components;

    use \Yii;
    use \CException;
    use \application\models\db\Plan;
    use \application\models\db\Event;

    abstract class ActionModel extends \CModel
    {

        /**
         * @var integer $plan
         */
        private $plan;

        /**
         * @var integer $event
         */
        private $event;

        /**
         * @var array $params
         */
        private $params = array();

        /**
         * Constructor
         *
         * @final
         * @access public
         * @param array $payload
         * @return void
         */
        final public function __construct(Plan $plan, Event $event, array $params = array())
        {
            $this->plan = $plan;
            $this->event = $event;
            $this->params = $params;
        }


        /**
         * Attribute Labels
         *
         * @access public
         * @return array
         */
        public function attributeNames()
        {
            $publicProperties = array();
            $reflection = new \ReflectionClass($this);
            foreach($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                $publicProperties[] = $property->getname();
            }
            return $publicProperties;
        }


        /**
         * Get: Safe Attribute Names
         *
         * Return an array of all the attribute names that are safe to be massively assigned via the "attributes" magic
         * property. Because this isn't actually a real model we'll return all of the attributes.
         *
         * @access public
         * @return array
         */
        public function getSafeAttributeNames()
        {
            return $this->attributeNames();
        }


        /**
         * Get: Name
         *
         * Generate a name for the current action model based on its class name using the same algorithm as CModel's
         * generateAttributeLabel() method.
         *
         * @static
         * @access public
         * @return string
         */
        public static function getName()
        {
            $className = preg_split('/\\\\/', get_called_class(), -1, PREG_SPLIT_NO_EMPTY);
            return ucwords(trim(strtolower(
                str_replace(
                    array('-','_','.'),
                    ' ',
                    preg_replace(
                        '/(?<![A-Z])[A-Z]/',
                        ' \0',
                        end($className)
                    )
                )
            )));
        }


        /**
         * Get: Plan
         *
         * @final
         * @access protected
         * @return Plan
         */
        final protected function getPlan()
        {
            if(!is_object($this->plan)) {
                $this->plan = \application\models\db\Plan::model()->findByPk($this->plan);
            }
            return $this->plan;
        }


        /**
         * Get: Event
         *
         * @final
         * @access protected
         * @return Event
         */
        final protected function getEvent()
        {
            if(!is_object($this->event)) {
                $this->event = \application\models\db\Event::model()->findByPk($this->event);
            }
            return $this->event;
        }


        /**
         * Get Payload Parameter
         *
         * @final
         * @access protected
         * @param string $name
         * @return mixed
         */
        final protected function getParam($name)
        {
            return isset($this->params[$name])
                ? $this->params[$name]
                : null;
        }


        /**
         * Run Action
         *
         * @abstract
         * @access public
         * @return boolean
         */
        abstract public function run();

    }
