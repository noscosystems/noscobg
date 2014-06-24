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
                'hint' => Yii::t('application', 'Please enter your firstname; it is case-insensitive.'),
            ),
            'middlename' => array(
                'type' => 'text',
                'maxlength' => 36,
                'hint' => Yii::t('application', 'Please enter your middlename; it is case-insensitive.'),
            ),
            'lastname' => array(
                'type' => 'text',
                'maxlength' => 36,
                'hint' => Yii::t('application', 'Please enter your lastname; it is case-insensitive.'),
            ),
            'old_pass' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
            'password' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
            'password2' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
            'priv' => array(
                'type' => 'dropdownlist',
                'items' => array(10 => 'User level', 50 => 'Admin level'),
                'prompt' => 'Please Select'
                // 'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),

        ),

        'buttons' => array(
            'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Update user')
            )
        ),
    );