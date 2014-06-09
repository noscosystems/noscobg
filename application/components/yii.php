<?php

/**
 * Yii bootstrap file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @package system
 * @since 1.0
 */

    require(dirname(__FILE__).'/../vendor/yiisoft/yii/framework/YiiBase.php');

    /**
     * Yii is a helper class serving common framework functionalities.
     *
     * It encapsulates {@link YiiBase} which provides the actual implementation.
     * By writing your own Yii class, you can customize some functionalities of YiiBase.
     *
     * @author Qiang Xue <qiang.xue@gmail.com>
     * @package system
     * @since 1.0
     */
    class Yii extends YiiBase
    {

        const LOG_LOGIN             = 196;
        const LOG_LOGIN_ADMIN       = 197;
        const LOG_POSTCODE          = 198;
        const LOG_SMS               = 199;
        const LOG_EMAIL             = 200;
        const LOG_LETTER            = 201;
        const LOG_PAYMENT           = 202;
        const LOG_DEFAULT           = 203;
        const LOG_COURT             = 204;
        const LOG_AUTH              = 205;
        const LOG_AUTH_UAT          = 206;
        const LOG_AUTH_ERROR        = 207;
        const LOG_CHECK             = 208;
        const LOG_CHECK_UAT         = 209;
        const LOG_CHECK_ERROR       = 210;
        const LOG_UPDATE_PASSWORD   = 211;
        const LOG_BANK_REFUND       = 212;
        const LOG_NEW_CUSTOMER      = 213;
        const LOG_PAYMENT_PLAN      = 214;
        const LOG_BANK_DEBIT        = 215;
        const LOG_NEW_DEBT          = 216;
        const LOG_MOBILE_DEBT       = 217;
        const LOG_CHASE_PLAN        = 218;
        const LOG_TRUSTSMART        = 219;


        /**
         * Record Log
         *
         * @static
         * @access public
         * @param integer $type
         * @param string $message
         * @param boolean $severity
         * @return void
         */
        public static function record($type, $message, $severity = null, array $extra = array())
        {
            // Determine if the type is a valid class constant.
            $reflection = new \ReflectionClass(__CLASS__);
            if(!preg_match('/^[1-9]\\d*$/', $type) || !in_array((int) $type, $reflection->getConstants())) {
                throw new CException(
                    Yii::t('application', 'Invalid log type passed to Yii::record().')
                );
            }
            if(!is_scalar($message) && !(is_object($message) && method_exists($message, '__toString'))) {
                throw new CException(
                    Yii::t('application', 'Cannot translate a non-scalar message to a string for persistent storage.')
                );
            }
            // Determine the action and customer values.
            $action = $customer = null;
            if(isset($extra['action']) && $extra['action'] instanceof \application\models\db\Action) {
                $action     = $extra['action']->id;
                $customer   = $extra['action']->customer;
            }
            elseif(isset($extra['customer']) && $extra['customer'] instanceof \application\models\db\Customer) {
                $customer   = $extra['customer']->id;
            }
            // Create a new log instance.
            $log = new \application\models\db\Log;
            $log->attributes = array(
                'type'      => (int) $type,
                'message'   => (string) $message,
                'created'   => time(),
                'user'      => Yii::app()->user->id,
                'branch'    => Yii::app()->user->branch,
                'action'    => $action,
                'customer'  => $customer,
                'ip'        => \application\components\IP::pton($_SERVER['REMOTE_ADDR']),
                'severity'  => $severity === null ? $severity : (bool) $severity,
            );
            // Use a try-catch block when attempting to save the log to the database, even though we throw an exception
            // anyway it is to prevent any database exceptions getting their message to the screen.
            try {
                if(!$log->save()) {
                    var_dump($log->errors);exit;
                    throw new CException;
                }
            }
            catch(CException $e) {
                throw new CException(
                    Yii::t('application', 'There was an error recording the log to the database.')
                );
            }
        }

        /**
         * Record Log
         *
         * @static
         * @access public
         * @param integer $type
         * @param string $message
         * @param integer|Action $action
         * @param boolean $severity
         * @return void
         */
        public static function recordAction($type, $message, $action, $severity = null)
        {
            if(!$action instanceof \application\models\db\Action) {
                $action = \application\models\db\Action::model()->findByPk($action);
            }
            if($action === null) {
                throw new CException(
                    Yii::t('application', 'Please supply a valid action model, or its ID, to create a log.')
                );
            }
            self::record($type, $message, $severity, array('action' => $action));
        }

        /**
         * Record Log
         *
         * @static
         * @access public
         * @param integer $type
         * @param string $message
         * @param integer|Customer $customer
         * @param boolean $severity
         * @return void
         */
        public static function recordCustomer($type, $message, $customer, $severity = null)
        {
            if(!$customer instanceof \application\models\db\Customer) {
                $customer = \application\models\db\Customer::model()->findByPk($customer);
            }
            if($customer === null) {
                throw new CException(
                    Yii::t('application', 'Please supply a valid action model, or its ID, to create a log.')
                );
            }
            self::record($type, $message, $severity, array('customer' => $customer));
        }

    }
