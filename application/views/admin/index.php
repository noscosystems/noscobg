<?php
    /**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');

$form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
echo $form->renderBegin();
$widget = $form->activeFormWidget;



if($widget->errorSummary($form)){
    echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
}
?>

<br />

<div class="col-sm-offset-2 col-sm-10 page-header">
  <h1>New Asset <small>Please fill in the form to create a new asset.</small></h1>
</div>

<div class="row">
    <div class="col-sm-3 control-label">Name of asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'name', array('class' => 'form-control') ); ?>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-sm-3 control-label">Type of asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'type', array('class' => 'form-control') ); ?>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-3 control-label">Area of asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'area', array('class' => 'form-control') ); ?>
    </div>
</div>

<br/>
<div class="row">
    <div class="col-sm-3 control-label">Asset created by:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'created_by', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Asset status:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'status', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Short description:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'short_desc', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Long desciption:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'long_desc', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label">Address:</div><div class="col-sm-offset-1 col-sm-1 control-label">Zip:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'zip_pc', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Town:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'town', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">County:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'county', array('cladss' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success',) ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>
