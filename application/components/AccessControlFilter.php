<?php
/**
 * AccessControlFilter class file.
 *
 * @author Zander Baldwin <mynameiszanders@gmail.com>
 * @link http://mynameis.zande.rs
 * @license http://www.yiiframework.com/license/
 */

    namespace application\components;

    use \Yii;
    use \CException;

    /**
     * Access Control Filter
     *
     * AccessControlFilter performs authorization checks for the specified actions.
     * By enabling this filter, controller actions can be checked for access permissions.
     * When the user is not denied by one of the security rules or allowed by a rule explicitly, they will be able to access
     * the action.
     *
     * @property array $rules
     *
     * @author Zander Baldwin <mynameiszanders@gmail.com>
     * @package application.components
     */
    class AccessControlFilter extends \CAccessControlFilter
    {

        /**
         * @var array $_rules
         */
        protected $_rules = array();

        /**
         * Get: Access Rules
         *
         * @access public
         * @return array
         */
        public function getRules()
        {
            return $this->_rules;
        }

        /**
         * Set: Access Rules
         *
         * @access public
         * @param array $rules
         * @return void
         */
        public function setRules($rules)
        {
            foreach($rules as $rule)
            {
                if(is_array($rule) && isset($rule[0]))
                {
                    $r = new AccessRule;
                    $r->allow = $rule[0] === 'allow';
                    foreach(array_slice($rule, 1) as $name => $value)
                    {
                        if($name === 'priv') {
                            if(is_int($value)) {
                                if($value < 0) {
                                    $r->priv = 0;
                                }
                                elseif($value > 100) {
                                    $r->priv = 100;
                                }
                                else {
                                    $r->priv = $value;
                                }
                            }
                            else {
                                throw new CException(
                                    Yii::t(
                                        'nosco',
                                        'Wrong data-type passed for the privilege level access control filter. Must be an integer.'
                                    )
                                );
                            }
                        }
                        elseif($name === 'expression' || $name === 'roles' || $name === 'message' || $name === 'deniedCallback') {
                            $r->$name = $value;
                        }
                        else {
                            $r->$name = array_map('strtolower', $value);
                        }
                    }
                    $this->_rules[] = $r;
                }
            }
        }

    }


    /**
     * Access Rule
     *
     * AccessRule represents an access rule that is managed by AccessControlFilter.
     *
     * @author Zander Baldwin <mynameiszanders@gmail.com>
     * @package application.components
     */
    class AccessRule extends \CAccessRule
    {

        /**
         * @var integer $priv
         * The minimum required user priviledge level.
         */
        public $priv;

        /**
         * Checks whether the Web user is allowed to perform the specified action.
         * @param CWebUser $user
         * @param CController $controller
         * @param CAction $action
         * @param string $ip
         * @param string $verb
         * @return integer
         */
        public function isUserAllowed($user, $controller, $action, $ip, $verb)
        {
            if(
                $this->isActionMatched($action)
             && $this->isUserMatched($user)
             && $this->isRoleMatched($user)
             && $this->isPrivMatched($user)
             && $this->isIpMatched($ip)
             && $this->isVerbMatched($verb)
             && $this->isControllerMatched($controller)
             && $this->isExpressionMatched($user)
            ) {
                return $this->allow ? 1 : -1;
            }
            else {
                return 0;
            }
        }

        /**
         * Is Privilege Level Matched?
         *
         * @access protected
         * @param WebUser $user
         * @return true
         */
        protected function isPrivMatched($user)
        {
            // Check if a privilege level has been set for this access rule.
            if(isset($this->priv) && is_int($this->priv)) {
                // Check if the user has been set a privilege level. If they haven't, set it to zero.
                $privilege = isset($user->priv) && preg_match('/^[1-9][0-9]*$/', $user->priv)
                    ? (int) $user->priv
                    : 0;
                // Check that the user has at least the required privilege level.
                return ($privilege >= $this->priv);
            }
            // Always return true so that this matching gets applied for the rule.
            return true;
        }

    }
