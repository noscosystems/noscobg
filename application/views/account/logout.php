<meta http-equiv="refresh" content="3; url=http://localhost/noscobg/public_html/home">

<?php

if(Yii::app()->user->hasFlash('account.logout.success')): ?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php echo Yii::app()->user->getFlash('account.logout.success'); ?>
	</div>
<?php endif;?>

