<?php
	/**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>
<div class="page-header">
  <h1>View Properties <small>Below is a list of your Properties.</small></h1>
</div>
<?php
$assets = Yii::app()->user->model()->Assets;

 if (!empty ( $assets )){

?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Property Name</th>
            <th class="text-center">Link to edit asset page</th>
            <th class="text-center">Link to add/delete images page</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach(Yii::app()->user->model()->Assets as $asset): ?>
            <tr>
                <td><?php echo $asset->name; ?></td>
                <td class="text-right"><?php echo CHtml::link('Edit Asset', array('/asset/editasset', 'id' => $asset->id ), array('class' => 'btn btn-sm btn-warning' ) ); ?></td>
                <td class="text-right"><?php echo CHtml::link('Add / Delete Images', array('/asset/images', 'id' => $asset->id ), array('class' => 'btn btn-sm btn-warning' ) ); ?></td>
            </tr>
        <?php endforeach; ?>
	</tbody>
</table>
<?php }else { ?>
        <div class="alert alert-warning">
        <span> You do not own any properties on the site currently!</span>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>  
<?php }
