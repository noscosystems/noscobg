<?php
	/**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');


$form->attributes = array('class' => 'form-horizontal');
echo $form->renderBegin();
$widget = $form->activeFormWidget;
?>


<?php
if($widget->errorSummary($form)){
    echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
}
?>

<?php if (Yii::app()->user->hasFlash('priv')): ?>
    <div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::app()->user->getFlash('priv') ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('success')){ ?>
    <div class="alert alert-success" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::app()->user->getFlash('success') ?>
    </div>
<?php }else if (Yii::app()->user->hasFlash('warning')){ ?>
    <div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::app()->user->getFlash('warning') ?>
    </div>
<?php } ?>

<div class="page-header">
    <h1>User profile <small>Please enter your changes to</small></h1>
</div>

<div class="row">
    <div class="col-sm-3 control-label">Change username:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'username', array('class' => 'form-control', 'value'=>$user->username) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Enter old password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'old_pass', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'password', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Repeat password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'password2', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change firstname:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'firstname', array('class' => 'form-control', 'value'=>$user->firstname) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change middlename:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'middlename', array('class' => 'form-control', 'value'=>$user->middlename) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change lastname:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'lastname', array('class' => 'form-control', 'value'=>$user->lastname) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change email:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'email', array('class' => 'form-control', 'value'=>$user->email) ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Change mobile number:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'mobile_number', array('class' => 'form-control', 'value'=>$user->mobile_number) ); ?>
    </div>
</div>
<br>
<?php //if (($user->priv<50)): ?>
<div class="row">
    <div class="col-sm-3 control-label">Select privilige level for this user:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'priv', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>

<?php //endif; ?>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success') ); ?>
    </div>
</div>

<?php echo $form->renderEnd(); ?>
</div><!-- form -->




