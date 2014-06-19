<?php

return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'old_pass' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please enter your old password here.'),
            ),
            'password' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please enter new password.'),
            ),
            'rep_new_pass' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please enter new password.'),
            )
        ),
			'buttons' => array(
            	'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Change password'),
            	),
        	)
      );

