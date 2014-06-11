<?php
    /**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>

<?php
$form->attributes=array('class' => 'form-horizontal');
echo $form->renderBegin();
$widget = $form->activeFormWidget;
?>

<?php if($widget->error($form, 'name') || $widget->error($form, 'password')): ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Errors Found!</strong> Your form has the following errors:<br />
            <?php
            echo $widget->error($form, 'username');
            echo $widget->error($form, 'password');
            ?>
    </div>
<?php endif; ?>

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
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success',) ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>
