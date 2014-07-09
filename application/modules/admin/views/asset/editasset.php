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

if(Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
<?php endif; ?>

<div class="col-sm-offset-2 col-sm-10 page-header">
  <h1>Asset details <small>Please edit your asset's details.</small></h1>
</div>

<div class="row">
    <div class="col-sm-3 control-label">Change name of asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'name', array('class' => 'form-control') ); ?>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-3 control-label">Area of asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'area', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change asset status:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'status', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change asset type:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'type', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change owner of the asset:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'owner', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Rent for a day:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rent_day', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Rent for a week:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rent_week', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Rent for a month:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rent_month', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Asset price:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'price', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Asset age:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'age', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Short description:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'short_desc', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Desciption:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'long_desc', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Active/Inactive:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'active', array('class' => 'form-control', 'title' => 'Select wether the asset is active ( available for buy,rent, etc ) or inactive (not avaible for buy, rent, sell, etc).') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label">Address:</div><div class="col-sm-offset-1 col-sm-1 control-label">Change country:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'country', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Change town:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'town', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Change district:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'district', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Change street:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'street', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Change building number:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'number', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label"> Chnage flat number:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'flat', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Change Zip:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'zip_pc', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
  <div class="col-sm-3 control-label"></div><div class="col-sm-offset-1 col-sm-1 control-label">Change County:</div>
    <div class="col-sm-4">
        <?php echo $widget->input($form, 'county', array('class' => 'form-control' ) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success', 'value' => 'Update Asset details.') ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>
