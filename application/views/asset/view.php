<?php
	/**
     * @var AssetController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');

if(Yii::app()->user->hasFlash('asset.view.success')):?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::app()->user->getFlash('asset.view.success'); ?>
    </div>
<?php endif;

	echo 'Add images to owned assets';

$form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
echo $form->renderBegin();
$widget = $form->activeFormWidget;

if($widget->errorSummary($form)): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $widget->errorSummary($form); ?>
    </div>
<?php endif; ?>

<?php echo $widget->input($form, 'asset', array('class' => 'form-control') ); ?>
<?php echo $widget->input($form, 'asset', array('class' => 'form-control' , 'value' => $_GET['id']) ); ?>
<div class="form-horizontal">
	<div class="col-sm-2 col-sm-offset-2">
		<input name="image1" type='file' />
	</div>
	<div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-xs btn-success', 'value' => 'Upload Image') ); ?>
    </div>
</div>
<br>
<?php echo $form->renderEnd(); ?>