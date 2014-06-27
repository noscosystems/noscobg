<?php


 
if(Yii::app()->user->hasFlash('user.logout.success')): ?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php echo Yii::app()->user->getFlash('user.logout.success'); ?>
	</div>
<?php endif; ?>