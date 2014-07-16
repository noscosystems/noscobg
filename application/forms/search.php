<?php

    use \application\models\db\Option;

    $options = Option::model()->findAllByAttributes(array ('column' => 'status'));
    $typeOfAssets = Option::model()->findAllByAttributes(array ('column' => 'type'));
    $status = [];
    $types = [];

    foreach ($options as $option)
        $status[$option->id] = $option->name;

    foreach ($typeOfAssets as $type)
        $types[$type->id] = $type->name;	

	return array(
        'title' => Yii::t('application', 'Please provide your login credentials.'),

        'elements' => array(
            'price_up' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter new password.'),
            ),
            'price_dn' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter new password.'),
            ),
			'area_up' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter new password.'),
            ),
            'area_dn' => array(
                'type' => 'text',
                'hint' => Yii::t('application', 'Please enter new password.'),
            ),
			'status' => array(
                'type' => 'dropdownlist',
                'items' => $status,
                'prompt' => 'Please Select'
                // 'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
			'type' => array(
                'type' => 'dropdownlist',
                'items' => $types,
                'prompt' => 'Please Select'
                // 'hint' => Yii::t('application', 'Please enter your password; it is case-sensitive.'),
            ),
        ),
			'buttons' => array(
            	'submit' => array(
                'type' => 'submit',
                'label' => Yii::t('application', 'Search'),
            	),
        	)
      );
	  
	  ?>