<?php

    namespace application\components;
    use \Yii;

    class FindReplace
    {
        public $text;
        public $rules;
        public $models;
        public $lineBreak;

        public function __construct($text = NULL, $rules = NULL, $models = NULL, $lineBreak = NULL)
        {
            $this->text = $text;
            $this->rules = $rules;
            $this->models = $models;
            if(!$lineBreak) $this->lineBreak = "<br />"; else $this->lineBreak = $lineBreak;
        }

        // Function will execute the find and replace sweep, replacing all search placeholders with results.
        public function execute($text = NULL, $rules = NULL, $models = NULL, $lineBreak = NULL)
        {
            if(!$text)   $text   = $this->text;
            if(!$rules)  $rules  = $this->rules;
            if(!$models) $models = $this->models;
            if(!$lineBreak) $lineBreak = $this->lineBreak;

            if(strlen($text) > 0){

                // If custom rules have been set, apply them.
                if($rules && is_array($rules))
                    foreach($rules as $search => $replace) $text = str_replace($search, $replace, $text);

                // Default rules, like branch etc.
                foreach($this->defaultRules() as $search => $replace) $text = str_replace($search, $replace, $text);

                // Cycle through the models given, if any are recognised, apply the rules.
                if($models && isset($models['customer']) && is_object($models['customer']))
                    foreach($this->customerRules($models['customer']) as $search => $replace) $text = str_replace($search, $replace, $text);

                // Cycle through the models given, if any are recognised, apply the rules.
        //        if($models && isset($models['action']) && is_object($models['action']))
        //            foreach($this->actionRules($models['action']) as $search => $replace) $text = str_replace($search, $replace, $text);

                // Check if a user model has been submitted as well.
                $userModel = ($models && isset($models['user'])) ? $models['user'] : NULL;
                // Find and replace using the user model
                foreach($this->userRules($userModel) as $search => $replace) $text = str_replace($search, $replace, $text);
            }

            return $text;
        }

        // Default rules set.
        public function defaultRules()
        {
            $rules = array(
                '[date]' => Yii::app()->dateFormatter->formatDateTime(time(), 'medium', NULL),
                '[time]' => Yii::app()->dateFormatter->formatDateTime(time(), NULL, 'short'),
            );
            return $rules;
        }

        // Rules for the customer if a model is supplied.
        public function customerRules($model)
        {

            $rules = array(
                '[sol]'             => $model->titleOption->name,
                '[full name]'       => $model->fullname,
                '[fn]'              => $model->firstname,
                '[mn]'              => $model->middlename,
                '[ln]'              => $model->lastname,
                '[address postcode]'=> strtoupper($model->Address->postcode),
                '[ni]'              => $model->ni,
                '[dob]'             => Yii::app()->dateFormatter->formatDateTime($model->dob, 'medium', NULL)
            );

            if($model->Contact){
                $merge = array(
                    '[mobile]'      => $model->Contact->mobile,
                    '[home]'        => $model->Contact->home,
                    '[email]'       => $model->Contact->email,
                    '[work]'        => $model->Contact->work,
                );
            } else {
                $merge = array(
                    '[mobile]'      => NULL,
                    '[home]'        => NULL,
                    '[email]'       => NULL,
                    '[work]'        => NULL,
                );
            }
            $rules = array_merge($rules, $merge);

            if($model->Address){
                $address = $model->Address->address1;
                if($model->Address->address2) $address .= $this->lineBreak . $model->Address->address2;
                $address .= $this->lineBreak . strtoupper($model->Address->postcode);
                $address .= $this->lineBreak . $model->Address->town;

                $merge = array(
                    '[address number]'  => $model->Address->number,
                    '[address name]'    => $model->Address->name,
                    '[address town]'    => $model->Address->town,
                    '[full address]'    => $address,
                );
            } else {
                $merge = array(
                    '[address number]'  => NULL,
                    '[address name]'    => NULL,
                    '[address town]'    => NULL,
                    '[full address]'    => NULL,
                );
            }
            $rules = array_merge($rules, $merge);

            return $rules;
        }

        // Rules for the user, a model does not need to be supplied.
        public function userRules($model = NULL)
        {
            if(!$model) $model = Yii::app()->user->model();

            $rules = array(
                '[staff]'          => $model->firstname,
                '[staff surname]'  => $model->lastname,
                '[branch name]'    => $model->Branch->name,
                '[branch tel]'     => $model->Branch->Contact->work,
                '[company name]'   => $model->Branch->Organisation->name,
            );

            return $rules;
        }

        public function actionRules($model)
        {
            $rules = array(
                // '[item]' => $model->replace;
            );

            if($model->Customer) $rules = array_merge($rules, $this->customerRules($model->Customer));
            if($model->Plan) $rules = array_merge($rules, $this->planRules($model->Plan));
            if($model->Plan && $model->Plan->Debt) $rules = array_merge($rules, $this->debtRules($model->Plan->Debt));
            if($model->Loan) $rules = array_merge($rules, $this->loanRules($model->Loan));

            return $rules;
        }

        public function debtRules($model)
        {
            $rules = array(
                // '[item]' => $model->replace;
            );

            return $rules;
        }

        public function planRules($model)
        {
            $rules = array(
                // '[item]' => $model->replace;
            );

            return $rules;
        }

        public function loanRules($model)
        {
            $rules = array(
                // '[item]' => $model->replace;
            );

            return $rules;
        }
    }