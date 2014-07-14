<?php
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?> 
<div class="row col-md-12">
    <div class="col-md-3">
        <div class="galleria">
            <?php foreach ($asset->Images  as $image ): ?>
                <img src="<?php echo Yii::app()->assetManager->publish($image->url); ?>" data-title="My title" data-description="My description">
            <?php endforeach; ?>
        </div>
    </div>
</div>
<style>
    .galleria{ 
        width: 400px;
        height: 300px;
        background: #000;
    }
</style>
<?php $bootstrap = Yii::app()->assetManager->publish(Yii::getPathOfAlias('composer.twbs.bootstrap.dist')); ?>

<script>
$(function() {
//$( document ).ready(function() {
// Handler for .ready() called.
    Galleria.loadTheme('<?php echo $bootstrap; ?>/js/galleria/themes/classic/galleria.classic.min.js');
    Galleria.run('.galleria');
});
</script>