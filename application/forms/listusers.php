<?php

    return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'search' => array(
                'type' => 'text',
                'maxlength' => 64,
                'class' => 'form-control',
                'hint' => 'Please enter your username',
                // 'label' => 'Username'
            ),
        ),
            'buttons' => array(
                'submit' => array(
                    'type' => 'submit',
                    'label' => Yii::t('application', 'Find user')
                )
            )
        );