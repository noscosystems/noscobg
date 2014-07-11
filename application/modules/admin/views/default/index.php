<?php
    /**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');

?>
<div class="jumbotron">
	<div class="container">
		<h1 class="text-center">Administration</h1>
		<p>Welcome to the administration section. Here you can create users and assets.</p>
		<p>
			<!-- <a class="btn btn-primary btn-lg">Learn more</a> -->
		</p>
	</div>
</div>



