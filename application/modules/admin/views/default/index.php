<?php
    /**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');

?>

<?php echo CHtml::link('Create user', array('user/createuser'), array ('class' => 'btn btn-sm btn-success') ); ?>
<br><br>
<?php echo CHtml::link('Create Asset', array('asset/index'), array ('class' => 'btn btn-sm btn-success') ); ?>
<br><br>
<?php echo CHtml::link('List users', array('/admin/listusers'), array ('class' => 'btn btn-sm btn-primary') ); ?>
<br><br>
<?php echo CHtml::link('List Assets', array('asset/listassets'), array ('class' => 'btn btn-sm btn-primary') ); ?>


