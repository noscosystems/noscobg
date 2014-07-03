<?php
    /**
     * @var AssetController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');

// $form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
// echo $form->renderBegin();
// $widget = $form->activeFormWidget;

?>

<table class="table table-hover">
	<tbody>
		<?php foreach ($images as $k => $v):?>
			<?php if ($k==0 || $k%3==0): ?>
				<tr>
					<?php endif; ?>
					<td>
						<?php echo CHtml::image(Yii::app()->assetManager->publish($v->url), $v->asset,
							array(
								'class' => 'img-rounded',
								'height' => '240',
								'width' => '300'
							));
						?>
						<input name="image1" type="file">
					</td>
			
		<?php endforeach; ?>
				</tr>
	</tbody>
</table>