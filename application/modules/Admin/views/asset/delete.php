<meta http-equiv="refresh" content="3; url=http://localhost/noscobg/public_html/admin/asset/listassets">

<?php
    /**
     * @var AssetController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
if(Yii::app()->user->hasFlash('success')){ ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
<?php }else if (Yii::app()->user->hasFlash('warning')){  ?>
	<div class="alert alert-warning">
        <?php echo Yii::app()->user->getFlash('warning'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
<?php }