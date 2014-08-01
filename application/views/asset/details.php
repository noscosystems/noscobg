<?php
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
	
	use \application\models\db\Option;
	use \application\models\db\Users;
?>

<div class="row col-md-12">
    <div class="col-md-8">
        	<?php if ($asset->Images!=null){ ?>
        <div class="galleria">
	            <?php foreach ($asset->Images  as $image ): ?>
	                <img src="<?php echo Yii::app()->assetManager->publish($image->url); ?>" data-title="My title" data-description="My description">
	            <?php endforeach; ?>
        </div>
        	<?php }else{ ?>
        	<div>Property doesn't have any images</div>
        	<?php } ?>
    </div>
	<div class="col-md-3 col-md-offset-1">
	<?php 
		$type = Option::model()->findByPk($asset->type);
		$status = Option::model()->findByPk($asset->status);
		$owner = Users::model()->findByPk($asset->owner);
		$rooms = $asset->Features;
	?>
		<table class="table">
			<tr>
				<td>
					Property name:
				</td>
				<td>
					<?php echo $asset->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					Property area:
				</td>
				<td>
					<?php echo $asset->area; ?>
				</td>
			</tr>
			<tr>
				<td>
					Property type:
				</td>
				<td>
					<?php echo $type->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					Property status:
				</td>
				<td>
					<?php echo $status->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rent for a day:
				</td>
				<td>
					<?php echo $asset->rent_day; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rent for a week:
				</td>
				<td>
					<?php echo $asset->rent_week; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rent for a month:
				</td>
				<td>
					<?php echo $asset->rent_month; ?>
				</td>
			</tr>
			<tr>
				<td>
					Price:
				</td>
				<td>
					<?php echo $asset->price; ?>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="col-md-12">
	<table class="table">
	<tr>
		<td>
			Property description:
		</td>
		<td>
			<p>
				<?php echo $asset->long_desc; ?>
			</p>
		</td>
	</tr>
	<tr>
		<td>Address of the Property:</td>
		<td>
			<p>
				<?php 
					echo ($asset->Address->country!='' or $asset->Address->country!=null)?($asset->Address->country).', ':('');
					echo ( $asset->Address->town!='' or $asset->Address->town!=null)?($asset->Address->town.', '):('');
				 	echo ($asset->Address->county!='' or $asset->Address->county!=null)?($asset->Address->county.', '):('');
				 	echo ($asset->Address->district!='' or $asset->Address->district!=null)?($asset->Address->district.', '):('');
					echo ($asset->Address->street!='' or $asset->Address->street!=null)?($asset->Address->street.', '):('');
					echo ($asset->Address->number!='' or $asset->Address->number!=null)?('Building number '.$asset->Address->number.', '):'';
					echo ($asset->Address->flat!='' or $asset->Address->flat!=null)?('Flat number '.$asset->Address->flat):('');
				?>
			</p>
		</td>
	</tr>
<?php if(!empty($rooms)): ?>
	<tr>
		<td>Features</td>
		<td>
			<div class="panel-group" id="accordion">
			<?php foreach ( $rooms as $k => $room ): ?>
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $k;?>">
						
						<h4 class="panel-title">
							<span>
								<?php echo  $room->type; ?>
							</span>
						</h4>
					</div>
					<div id="<?php echo $k;?>" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-4">
									Area:
								</div>
								<div class="col-sm-8">
									<?php echo $room->area; ?>
								</div>
							<div class="col-sm-4">
									Feature description:
								</div>
								<div class="col-sm-8">
									<p><?php echo $room->desc; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
					<?php endforeach; ?>
			</div>
		</td>
	</tr>
<?php endif; ?>
	<tr>
		<td>
			Owner of the property:
		</td>
		<td>
			<?php  
				echo (( $owner->firstname!='' && $owner->firstname!=null )?($owner->firstname):'').' ';
				echo (( $owner->middlename!='' && $owner->middlename!=null )?($owner->middlename):'').' ';
				echo (( $owner->lastname!='' && $owner->lastname!=null )?($owner->lastname):'').' ';
			?>
		</td>
	</tr>
	<tr>
		<td>
			Owner's mobile:
		</td>
		<td>
			<?php  echo (isset($owner->mobile_number) && $owner->mobile_number!='' && $owner->mobile_number!=null )?($owner->mobile_number):'Not present.'; ?>
		</td>
	</tr>
	<tr>
		<td>
			Owner's email:
		</td>
		<td>
			<?php  echo (isset($owner->email) && $owner->email!='' && $owner->email!=null )?($owner->email):'Not present.'; ?>
		</td>
	</tr>
	</table>
</div>
<style>
    .galleria{ 
        width: 620px;
        height: 465px;
        background: #000;
    }
	.textarea{
		resize: none;
	}
</style>
<?php $bootstrap = Yii::app()->assetManager->publish(Yii::getPathOfAlias('composer.twbs.bootstrap.dist')); ?>

<script>
$(function() {
//$( document ).ready(function() {
// Handler for .ready() called.
	var galleria = document.getElementsByClassName('galleria');
	if (galleria.length>0){
		Galleria.loadTheme('<?php echo $bootstrap; ?>/js/galleria/themes/classic/galleria.classic.min.js');
	    Galleria.run('.galleria', {
		    extend: function(options) {

		        Galleria.log(this) // the gallery instance
		        Galleria.log(options) // the gallery options

		        // listen to when an image is shown
		        this.bind('image', function(e) {

		            Galleria.log(e) // the event object may contain custom objects, in this case the main image
		            Galleria.log(e.imageTarget) // the current image

		            // lets make galleria open a lightbox when clicking the main image:
		            $(e.imageTarget).click(this.proxy(function() {
		               this.openLightbox();
		            }));
		        });
		    }
		});
	}
});

</script>