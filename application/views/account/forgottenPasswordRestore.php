<?php
    /**
     * @var AccountController	$this
     * @var CForm           	$form
     */
    $this->pageTitle = Yii::t('application', 'Login');
    $this->breadcrumbs = array(
        $this->pageTitle,
    );

	$form->attributes = array ('class' => 'form-horizontal');
	echo $form->renderBegin();
	$widget = $form->activeFormWidget;

	if($widget->errorSummary($form))
	    echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
?>
<?php if (Yii::app()->user->hasFLash('pass')){?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo Yii::app()->user->getFlash('pass');?>
</div>
<?php } ?>

<br>

<div class="row">
    <div class="col-sm-3 control-label">Enter new password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'new_pass', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-3 control-label">Repeat new password:</div>
    <div class="col-sm-6">
        <?php echo $widget->input($form, 'rep_pass', array('class' => 'form-control') ); ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-2 col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success',) ); ?>
    </div>
</div>
<?php echo $form->renderEnd(); ?>