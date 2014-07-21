<?php
    /**
     * @var AssetController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');

$form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
echo $form->renderBegin();
$widget = $form->activeFormWidget;

if($widget->errorSummary($form)){ ?>
    <div class="alert alert-danger">
    	<?php echo $widget->errorSummary($form) ?>
    </div>
<?php }

if(Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success');
?>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
<?php endif; ?>

<div class="col-sm-offset-2 col-sm-10 page-header">
  <h1>Create new room for <small>asset</small></h1>
</div>

<div class="row">
    <div class="col-sm-3 control-label">Type of room</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'type', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Area of room:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'area', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Description of the room:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'desc', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success' ) ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>