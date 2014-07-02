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

foreach(Yii::app()->user->model()->Assets as $asset){
  foreach ($asset->Images as $image){
    echo $image->url;
  }
}
?>
<?php
    
    foreach(Yii::app()->user->model()->Assets as $asset){
      foreach ($asset->Images as $image){
        echo '<pre>';
        var_dump($image);
        echo '</pre>';
      }
    }

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
