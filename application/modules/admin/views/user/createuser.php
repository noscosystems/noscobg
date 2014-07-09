<?php

$form->attributes = array('class' => 'form-horizontal');
echo $form->renderBegin();
$widget = $form->activeFormWidget;
?>

<div class="page-header">
    <h1>Create a user <small>Please enter the user's information</small></h1>
</div>

<?php if(Yii::app()->user->hasFlash('account.register.success')): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::app()->user->getFlash('account.register.success'); ?>
    </div>
<?php endif; ?>

<?php
if($widget->errorSummary($form)){
    echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
}
?>

<div class="row">
    <div class="col-sm-3 control-label">Enter Username:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'username', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Enter Password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'password', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Enter firstname here:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'firstname', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Enter middlename here:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'middlename', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Enter lastname here:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'lastname', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Select gender</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'gender', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Please type in the exact date of birth</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'dob', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success', 'value' => 'Create User') ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>
</div><!-- form -->
