<?php

    namespace application\components;

    class Rank
    {
        /**
         * Get: Name
         * Description: Get the name of the rank by passing an integer.
         *
         * @param $rank int
         *
         * @access public
         * @return string
         */
        public static function getName($rank)
        {
            if($rank <= 10)     return "Basic User";
            elseif($rank <= 20) return "Branch Manager";
            elseif($rank <= 30) return "Regional Administrator";
            elseif($rank <= 40) return "Branch Administrator";
            elseif($rank <= 70) return "Organisation Administrator";
            elseif($rank <= 90) return "Nosco Staff";
            else                return "Nosco Administrator";
        }

        /**
         * Get: Name
         * Description: Get the name of the rank by passing a user model.
         *
         * @param $rank User Model
         *
         * @access public
         * @return string
         */
        public static function getUserName($user)
        {
            if(!$user)
                return false;

            return $this->getName($user->priv);
        }

    }