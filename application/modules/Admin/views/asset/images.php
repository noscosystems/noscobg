<?php
    /**
     * @var AssetController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');



?>

<style>
/*table tr td:hover {
	background-color: #e8e8e8;
}*/
.image-hover{
	position:relative;
}
.overlay {
	/*text-align: center;*/
	top:0;
	left:0;
	width:100%;
	height:100%;
	z-index:50;
	display: none;
	position: absolute;
	background: rgba (0,0,0, 0.2);
	/*opacity:0.2;*/
	/*filter: alpha ( opacity=40 );*/
}
</style>

<table class="table">
	<tbody>
		<?php foreach ($images as $k => $v):?>
			<?php if ($k==0 || $k%3==0): ?>
				<tr>
			<?php endif; ?>
					<td>
						<div class="image-hover">
							<?php echo CHtml::image(Yii::app()->assetManager->publish($v->url), $v->asset,
								array(
									'class' => 'img-rounded',
									'height' => '240',
									'width' => '300'
								));
							?>
							<div class="overlay">
		        				<?php echo CHtml::link('Delete', array('delete', 'id' => $v->id), array('class' => 'btn btn-danger')); ?>
		        			</div>
						</div>
					</td>
			
		<?php endforeach; ?>
				</tr>
	</tbody>
</table>

<?php //$this->renderPartial('//modals/help'); ?>


<script>
$(document).ready( function (){
	$(".image-hover").hover( function(){
			// What happens when the mouse is hovered
			$(this).children('.overlay').show();
		}, function(){
			// What happens the mouse leaves
			$(this).children('.overlay').hide();
		
		});
});
</script>