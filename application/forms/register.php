<?php

    return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'username' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter your username; it is case-insensitive.'),
            ),
            'firstname' => array(
                'type' => 'text',
                'maxlength' => 36,
                'hint' => Yii::t('application', 'Please enter your username; it is case-insensitive.'),
            ),
            'middlename' => array(
                'type' => 'text',
                'maxlength' => 36,
                'hint' => Yii::t('application', 'Please enter your username; it is case-insensitive.'),
            ),
            'lastname' => array(
                'type' => 'text',
                'maxlength' => 36,
                'hint' => Yii::t('application', 'Please enter your username; it is case-insensitive.'),
            ),
            'password' => array(
                'type' => 'password',
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
            'priv' => array(
                'type' => 'hidden',
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
            'dob' => array(
                'type' => 'hidden',
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
            'gender' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),

        ),

        'buttons' => array(
            'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Register'),
            ),
        ),
    );