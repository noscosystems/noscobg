<?php

return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'asset' => array(
                'type' => 'hidden',
                'maxlength' => 11,
                'hint' => Yii::t('application', ''),
            ),
        ),

        'buttons' => array(
            'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Upload images'),
            ),
        ),
    );
?>