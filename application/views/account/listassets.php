<?php
	/**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>
<div class="page-header">
  <h1>View Assets <small>Below is a list of your Assets.</small></h1>
</div>
<?php
$assets = Yii::app()->user->model()->Assets;

 if (!empty ( $assets )){

?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Asset Name</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach(Yii::app()->user->model()->Assets as $asset): ?>
            <tr>
                <td><?php echo CHtml::link($asset->name, array('/asset/view', 'id' => $asset->id, 'asset_name' => $asset->name)); ?></td>
            </tr>
        <?php endforeach; ?>
	</tbody>
</table>
<?php }else { ?>
        <div class="alert alert-warning">
        <span> You do not own any assets on the site currently!</span>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>  
<?php }
