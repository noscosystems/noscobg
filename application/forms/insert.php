<?php

    // namespace application\controllers;

    use \application\models\db\Users;

    $users = Users::model()->findAll();
    $userItems = array();
    foreach($users as $user)
        $userItems[$user->id] = $user->username;

    return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'name' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter a name for the asset; it is case-insensitive.'),
            ),
            'area' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter area of the asset; it is case-sensitive.'),
            ),
            'status' => array(
                'type' => 'text',
                'maxlength' => 11,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'owner' => array(
                'type' => 'dropdownlist',
                'items' => $userItems,
                'prompt' => 'Please Select'
                // 'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
            'age' => array(
                'type' => 'text',
                'maxlength' => 11,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'price' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'rent_day' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'rent_week' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'rent_month' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'short_desc' => array(
                'type' => 'text',
                'maxlength' => 128,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'long_desc' => array(
                'type' => 'text',
                'maxlength' => 65535,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'zip_pc' => array(
                'type' => 'text',
                'maxlength' => 12,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.'),
            ),
            'town' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.')
            ),
            'country' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.')
            ),
            'street' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.')
            ),
            'number' => array(
                'type' => 'text',
                'maxlength' => 11,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.')
            ),
            'flat' => array(
                'type' => 'text',
                'maxlength' => 11,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.')
            ),
            'district' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.')
            ),
            'county' => array(
                'type' => 'text',
                'maxlength' => 64,
                'hint' => Yii::t('application', 'Please enter asset status; it is case-insensitive.')
            )
        ),

        'buttons' => array(
            'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Create Asset'),
            ),
        ),
    );