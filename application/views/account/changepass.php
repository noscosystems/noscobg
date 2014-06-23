<?php
/* @var $this AccountController */

$this->breadcrumbs=array(
	'Account',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$form->attributes=array('class' => 'form-horizontal');
echo $form->renderBegin();
$widget = $form->activeFormWidget;

if($widget->errorSummary($form)){
    echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
}
?>
<?php if (Yii::app()->user->hasFLash('success')){?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <!-- <strong></strong> -->
    <?php echo Yii::app()->user->getFlash('success');?>
</div>
<?php } ?>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Enter your old password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'old_pass', array('class' => 'form-control') ); ?>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-3 control-label">Enter new password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'password', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Repeat new password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rep_new_pass', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success',) ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>
