<?php
	/**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');

	echo 'Add images to owned assets';
?>
<?php //echo CHtml::link('Link Text',array('admin/index')); ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th>table header</th>
		</tr>
	</thead>
	<tbody>
<?php

	use \application\models\db\Assets;
	$assets = Assets::model()->findAllByAttributes(array('created_by'=>Yii::app()->user->getId()));
    $assetItems = [];
    foreach ($assets as $k => $v){
        $assetItems [$v->id] = $v->name;
    }
    echo '<pre>';
    var_dump($assetItems);
    echo '</pre>';

	foreach ($assetItems as $kk => $vv){
        echo '<tr><td>'.CHtml::link($vv,array('admin/ownedassets','id' => $kk,'asset_name'=> $vv)).'</td></tr>';
    }
?>
	</tbody>
</table>