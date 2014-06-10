<?php
    // Do not worry about this variable. You will come across its reasoning later.
    $persistentClass = 'form-control';

    return array(
        // Set the elements that you wish to use, the format is as follows:
        'elements' => array(
            // Create the element, use the name as the main identifier. The name should also match the model.
            // For example, if the name is 'example' then the model should have a variable called '$example'.
            'nameOfElement' => array(
                // Here you specify the html options for the element.
                // The reason why the options are specified here and not in the view is so the views/controllers that use 
                //  this configuration have default settings, for example, the class of the element.

                // This means that you can specify all fields to have similar classes by specifying the variable at the top of the page.
                'class' => $persistentClass,

                // You must however specify the type. As Yii uses the name of the type to determine how the input will act with the model.
                'type' => 'text',
                'type' => 'textarea',
                'type' => 'dropdownlist',
                'type' => 'checkbox',
                'type' => 'radio',

                // Specifying a hint is optional with Yii, Yii will pickup a hint and you can use the widget to display it or check for it.
                'hint' => 'This is an example hint',

                // To add items to a dropdownlist, you simply state the element with an array of options.
                'items' => array(
                        'Option One',
                        'Option Two',
                        // You can also specify a key or a value to a label:
                        3 => 'Option Three',
                        'Text Value' => 'Label',
                    ),

                // You can also set a prompt, basically what will show on the dropdownlist by default.
                'prompt' => 'Please Select...',

                // Finally, it is good practice to set a label, that way, if the nature of the form changes and you need to change the name
                // of a field, you do not need to update all the views that use this form configuration, only this file. Imagine the concept
                // of using file includes or stylesheets, instead of having to update every page, you update the single page which then 
                // reflects on the rest of the system.
                'label' => 'Label to the Element',
            ),

            // A typical username element will look like the following:
            'username' => array(
                'type' => 'text',
                'maxlength' => 30,
                'class' => 'form-control',
                'hint' => 'Please enter your username',
                'label' => 'Username'
            ),

            // Here is an exmaple of using a dropdownlist
            'gender' => array(
                'type' => 'dropdownlist',
                'items' => array(0 => 'Female', 1 => 'Male'),
                'prompt' => 'Please Select',
            ),
        ),

        // The buttons are used to submit the form, usually you will only need the one and quite typically, it will only need a certain amount
        // of properties.
        'buttons' => array(
            'submit' => array(
                // Again, the properties usually reflect HTML options aside from the type, hint and label.
                // You can still assign other properties along with any custom properties.

                // Quite often, infact I've never had it where a button has been anything else, the type will be submit.
                'type' => 'submit',
                // The label is always good to set, this is the same as setting the default value 
                'label' => 'Letters that appear on button',
            ),
        ),
    );
