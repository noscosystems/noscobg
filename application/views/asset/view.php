<?php
	/**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
	echo 'Add images to owned assets';

$form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
echo $form->renderBegin();
$widget = $form->activeFormWidget;

if($widget->errorSummary($form)){
    echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
}
?>
<?php echo $widget->input($form, 'asset', array('class' => 'form-control') ); ?>
<?php echo $widget->input($form, 'asset', array('class' => 'form-control' , 'value' => $_GET['id']) ); ?>
<input name="image1" type='file'>

<div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success',) ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>