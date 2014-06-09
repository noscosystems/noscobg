<?php
    // 99% of the time, you will always have the namespace and the use statements, I will explain why:
    // The namespace we have never actually utilised to its full potential, infact its more of a pain to use.
    // Naturally, Yii does not use them but Zander has insisted that we use them to get used to them.
    // It pretty much allows us to specify different files with the same names that refer to different paths, or something like that.
    // Zander would love to explain it...
    namespace application\models\form;

    // Using Yii, agian pretty standard, reason being is that you may using functions like translate, or encode, or Yiisoft etc.
    use \Yii;
    // CException is error handling, it will allow you to create custom form error checking and display Exceptions (or errors) to the user.
    use \CException;
    // Finally, you need to be able to use the FormModel, basically saying that this class extends the FormModel, google for more info.
    use \application\components\FormModel;

    // The classname should always be the same name as the file, this is how Yii finds the classes.
    class Example extends FormModel
    {

        // Now you specify the variables you need.
        // These variable will ALWAYS be the same as the elements in the form configuration.
        // For example, if you have three elements in the form configuration named "foo", "bar" and "foobar",
        // then you will have three variables with the same names to reflect that.
        // As follows:
        public $foo;
        public $bar;
        public $foobar;
        // Why public? So the Form constructor can access the properties (ie: $form->model->foo)

        // Usually, this will be the only function that you need. This will let you define the constant rules needed by the model.
        public function rules()
        {
            return array(
                // So the syntax for setting a rule is as follows:
                array('foo, bar, foobar', 'ruleType', 'params' => $params, 'params' => $params),
                // Notice how I specified all three elements use the same rule there, this is useful and saves time.
                
                // Here I will list some of the rules you can have, if you want more, Google or go to \application\components\FormModel.
                array('foo', 'required'),
                array('foo', 'length', 'min' => 5, 'max' => 10, 'exact' => 6),
                array('foo', 'numerical', 'integerOnly' => true/false, 'min' => 5, 'max' => 100),
                array('foo', 'pattern', 'match' => '/$[0-9]{5}d+^/'), // Any regex patterns.

                // In order to set a custom error message, use the following syntax, I will use rule 'required' as an example:
                array('bar', 'required', 'message' => 'You have left {{attribute}} blank, it is a required field. Fill it in!'),
                // Notice how I used "{{attribute}}"? Well Yii will look for that and replace it with the attribute that has the error.
            );
        }


    }
