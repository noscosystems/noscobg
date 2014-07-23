<?php

return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'new_pass' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please enter your new password here.'),
            ),
            'rep_pass' => array(
                'type' => 'password',
                'maxlength' => 60,
                'hint' => Yii::t('application', 'Please re-enter new password here.'),
            )
        ),
			'buttons' => array(
            	'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Submit new password'),
            	),
        	)
      );