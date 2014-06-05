<?php
// Add the namespace here:
namespace application\models\db;
// Along with the correct "use"'s/
use \Yii;
use \CException;
use \application\components\ActiveRecord;

// Make sure that the extends is changed from CActiveRecord to ActiveRecord
class ModelName extends ActiveRecord
{

    public function relations()
    {
        // Fix the relation to have proper capitals and the path to models to be updated.
        return array(
            'RelationName' => array(self::BELONGS_TO, '\\application\\models\\db\\Model', 'column'),
        );
    }
}
