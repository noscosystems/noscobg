<?php
    /**
     * @var AssetController $this
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
<div class="col-sm-offset-2 col-sm-10 page-header">
  <h1>New Asset <small>Please fill in the form to create a new asset.</small></h1>
</div>

<div class="row">
    <div class="col-sm-3 control-label">Name of asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'name', array('class' => 'form-control') ); ?>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-3 control-label">Area of asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'area', array('class' => 'form-control') ); ?>
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
    <div class="col-sm-3 control-label">Owner of the asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'owner', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Price rent for a day:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rent_day', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Price rent for a week:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rent_week', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Price rent for a month:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rent_month', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Asset price:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'price', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Asset age:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'age', array('class' => 'form-control') ); ?>
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
  <div class="col-sm-3 control-label">Address:</div><div class="col-sm-offset-1 col-sm-1 control-label">Country:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'country', array('class' => 'form-control') ); ?>
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
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">District:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'district', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Street:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'street', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Building number:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'number', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Flat number:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'flat', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Zip:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'zip_pc', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">County:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'county', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success',) ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>
