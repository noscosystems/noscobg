<?php

    // namespace application\controllers;

    // use \application\models\db\Users;
    // use \application\models\db\Option;

    // $options = Option::model()->findAllByAttributes(array ('column' => 'room_type'));
    // $type = [];

    // foreach ($options as $option)
    //     $type[$option->id] = $option->name;

    return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'area' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter area of the asset; it is case-sensitive.'),
            ),
            'type' => array(
                'type' => 'text',
                'maxlength' =>  30,
                'hint' => Yii::t('application', 'Please select asset status; it is case-insensitive.'),
            ),
            'desc' => array(
                'type' => 'textarea',
                'maxlength' => 	256,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
        	), 
		),
        'buttons' => array(
            'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Create Feature'),
            )
        ));