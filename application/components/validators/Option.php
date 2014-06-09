<?php

    namespace application\components\validators;

    use \Yii;
    use \CException;
    use \CValidator as Validator;
    use \application\models\db\Option as OptionModel;

    class Option extends Validator
    {

        /**
         * @var string|array $category
         */
        public $category;

        /**
         * @var boolean $allowEmpty
         */
        public $allowEmpty = true;

        /**
         * Validate Attribute
         *
         * @access public
         * @param CModel $model
         * @param string $attribute
         * @return void
         */
        protected function validateAttribute($model, $attribute = null)
        {
            // In order to use the option validator, an option category must be specified.
            if($this->isEmpty($this->category)) {
                throw new CException(
                    Yii::t('chaser', 'A category must be specified in order to use the Option validator.')
                );
            }
            // Put the value of the model attribute into a variable for easy reference.
            $value = isset($model->$attribute) ? $model->$attribute : null;
            // Is the value is empty?
            if($this->isEmpty($value)) {
                // However, if the validation rule specifies that it cannot be empty, add an error to the model
                // attribute.
                if(!$this->allowEmpty) {
                    $message = Yii::t('chaser', '{attribute} cannot be blank.');
                    $this->addError($model, $attribute, $message);
                }
                // Either way, if the value is empty, we should return from this method anyway as there is no point
                // performing a database check when we know it will fail.
                return;
            }
            // Perform the database check to make sure that the option ID passed belongs to the category specified.
            // Luckily a method exactly for this purpose exists in the Option database model; how convinient.
            if(!OptionModel::isValidCategory($value, $this->category)) {
                // Bad luck, turns out that it isn't part of the correct category, decide what error message we're going
                // to attach to the form attribute.
                $message = is_string($this->message) && !empty($this->message)
                    ? $this->message
                    : Yii::t('chaser', 'The selected option for {attribute} is not valid.');
                // Aaaaand, add it.
                $this->addError($model, $attribute, $message);
            }
            // We're done!
        }

    }
