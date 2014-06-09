<?php

    namespace application\components;

    use \Yii;
    use \CException;
    use \Symfony\Component\Finder\Finder;

    class ActionManager
    {

        private static $suffix = '.php';
        private static $actionNamespace = array(
            'application',
            'models',
            'action',
        );
        private static $shortcuts = array(
            'sms'       => '\\application\\models\\action\\SendSMS',
            'letter'    => '\\application\\models\\action\\PrintLetter',
            'email'     => '\\application\\models\\action\\SendEmail',
            'rollover'  => '\\application\\models\\action\\RolloverLoan',
            'stepdown'  => '\\application\\models\\action\\StepdownLoan',
            'default'   => '\\application\\models\\action\\LoanDefaulted',
            'escalate'  => '\\application\\models\\action\\EscalateToHeadOffice',
        );
        protected $payload;

        protected $plan;
        protected $events;


        /**
         * List Available Actions
         *
         * @static
         * @access public
         * @return array
         */
        public static function listAvailableActions()
        {
            $actionModels = array();
            $finder = new Finder;
            $finder
                ->files()
                ->in(Yii::getPathOfAlias(implode('.', self::$actionNamespace)))
                ->name('*' . self::$suffix);
            foreach($finder as $file) {
                $className = $file->getBasename(self::$suffix);
                if($className = self::isValidActionModel($className)) {
                    $actionModels[] = $className;
                }
            }
            return $actionModels;
        }


        /**
         * List Items
         *
         * Create an array list of available actions for a dropdown input.
         *
         * @static
         * @access public
         * @return array
         */
        public static function items()
        {
            $items = array();
            $actions = self::listAvailableActions();
            foreach($actions as $action) {
                $actionType = array_search($action, self::$shortcuts, true) ?: $action;
                $items[$actionType] = $action::getName();
            }
            return $items;
        }


        /**
         * Is Valid Action Model?
         *
         * @static
         * @access public
         * @param string $className
         * @return boolean|string
         */
        public static function isValidActionModel($className)
        {
            if(is_string($className)) {
                if(isset(self::$shortcuts[$className])) {
                    $className = self::$shortcuts[$className];
                }
                elseif(strpos($className, '\\') === false) {
                    $className = '\\' . implode('\\', self::$actionNamespace) . '\\' . $className;
                }
                return class_exists($className) && is_subclass_of($className, '\\application\\components\\ActionModel')
                    ? $className
                    : false;
            }
            return false;
        }


        /**
         * Constructor
         *
         * @access public
         * @return void
         */
        public function __construct(\application\models\db\Plan $plan)
        {
            if($plan->isNewRecord) {
                throw new CException(
                    Yii::t(
                        'chaser',
                        'Loan payment plan must be persisted to the database in order to be used to fire events and their actions.'
                    )
                );
            }
            $this->plan = $plan;
        }


        /**
         * Get Payload
         *
         * @access protected
         * @return array
         */
        protected function getPayload()
        {
            return is_array($this->payload)
                ? $this->payload
                : array();
        }


        /**
         * Has Event?
         *
         * @access public
         * @param integer|Event $event
         * @return boolean
         */
        public function hasEvent(\application\models\db\Event $event)
        {
            $this->listEvents();
            return isset($this->events[$event->id]);
        }


        /**
         * Has Event Fired?
         *
         * @access public
         * @param integer|Event $event
         * @return boolean
         */
        public function hasEventFired(\application\models\db\Event $event)
        {
        }


        /**
         * List Events
         *
         * @access public
         * @return Event[]
         */
        public function listEvents()
        {
            if(is_array($this->events)) {
                return $this->events;
            }
            $sql = 'SELECT      `event`.*
                    FROM        `{{plan}}`      AS `plan`
                    LEFT JOIN   `{{strategy}}`  AS `strategy`   ON `strategy`.`id`      = `plan`.`strategy`
                    LEFT JOIN   `{{event}}`     AS `event`      ON `event`.`strategy`   = `strategy`.`id`
                    WHERE       `plan`.`id`     =  :plan
                        AND     `event`.`id`    IS NOT NULL';
            $events = \application\models\db\Event::model()->findAllBySql($sql, array(
                ':plan' => $this->plan->id,
            ));
            $return = array();
            foreach($events as $event) {
                #if($this->isValidActionModel($event->action)) {
                    $return[$event->id] = $event;
                #}
            }
            return $this->events = $return;
        }


        /**
         * Can Fire Event?
         *
         * @access public
         * @param integer|Event $event
         * @return boolean
         */
        public function canFireEvent(\application\models\db\Event $event)
        {
            if(!$this->hasEvent($event)) {
                return false;
            }
            $expressionLanguage = new \Symfony\Component\ExpressionLanguage\ExpressionLanguage;
            try {
                return !$this->hasEventFired($event)
                    && $expressionLanguage->evaluate($event->rule, $this->getPayload());
            }
            catch(\Exception $e) {
                return false;
            }
        }


        /**
         * Fire Event
         *
         * @access public
         * @param integer|Event $event
         * @return void
         */
        public function fireEvent(\application\models\db\Event $event)
        {
            if($this->canFireEvent($event)) {
                $action = $this->isValidActionModel($event->action);
                if(is_string($action)) {
                    $action = new $action($this->plan, $event);
                    if($action->run()) {
                        $act = new \application\models\db\Act;
                        $act->attributes = array(
                            'plan'      => $this->plan->id,
                            'event'     => $event->id,
                            'action'    => $event->action,
                            'created'   => time(),
                        );
                        $act->save();
                        return true;
                    }
                }
            }
            return false;
        }


        /**
         * Fire All Automatic Events
         *
         * @access public
         * @return void
         */
        public function fireAutomaticEvents()
        {
        }

    }
