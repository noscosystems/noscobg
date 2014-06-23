<?php

    return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'priv[]' => array(
                'type' => 'dropdownlist',
                'items' => array(0 => '10', 1 => '50'),
                'prompt' => 'Please Select'
                // 'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
        ),
            'buttons' => array(
                'submit' => array(
                    'type' => 'submit',
                    'label' => Yii::t('application', 'Set priviliges')
                ),
            )
        );