<?php
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
	
	use \application\models\db\Option;
	use \application\models\db\Users;
?> 
<div class="row col-md-12">
    <div class="col-md-8">
        <div class="galleria">
            <?php foreach ($asset->Images  as $image ): ?>
                <img src="<?php echo Yii::app()->assetManager->publish($image->url); ?>" data-title="My title" data-description="My description">
            <?php endforeach; ?>
        </div>
    </div>
	<div class="col-md-3 col-md-offset-1">
	<?php 
		$type = Option::model()->findByPk($asset->type);
		$status = Option::model()->findByPk($asset->status);
		$owner = Users::model()->findByPk($asset->owner);
		$rooms = $asset->Rooms;
	?>
		<table class="table">
			<tr>
				<td>
					Asset name:
				</td>
				<td>
					<?php echo $asset->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					Asset area:
				</td>
				<td>
					<?php echo $asset->area; ?>
				</td>
			</tr>
			<tr>
				<td>
					Asset type:
				</td>
				<td>
					<?php echo $type->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					Asset status:
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
			Asset description:
		</td>
		<td>
			<p>
				<?php echo $asset->long_desc; ?>
			</p>
		</td>
	</tr>
	<tr>
		<td>Address of the Asset:</td>
		<td>
			<p>
				<?php echo $asset->Address->country; ?>
				, 
				<?php echo $asset->Address->town; ?>
				, 
				<?php echo $asset->Address->county; ?>
				, 
				<?php echo $asset->Address->district; ?>
				, 
				Building number 
				<?php echo $asset->Address->number; ?>
				, 
				<?php echo $asset->Address->street; ?>
				 
				<?php echo $asset->Address->flat; ?>
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="panel-group" id="accordion">
			<?php foreach ( $rooms as $k => $room ): ?>
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $k; ?>">
						
						<h4 class="panel-title">
							<a >
								<!-- Room 1 -->
								<?php echo  $room->Type->name; ?>
							</a>
						</h4>
					</div>
					<div id="<?php echo $k; ?>" class="panel-collapse collapse">
						<div class="panel-body">
							<!-- Room desc. -->
							<?php echo $room->area; ?>
							<?php echo $room->desc; ?>
						</div>
					</div>
				</div>
					<?php endforeach; ?>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			Owner of the asset:
		</td>
		<td>
			<?php  
				echo ((isset($owner->firstname) && $owner->firstname!='' && $owner->firstname!=null )?($owner->firstname):'').' ';
				echo ((isset($owner->middlename) && $owner->middlename!='' && $owner->middlename!=null )?($owner->middlename):'').' ';
				echo ((isset($owner->lastname) && $owner->lastname!='' && $owner->lastname!=null )?($owner->lastname):'').' ';
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
			Owner of the asset:
		</td>
		<td>
			<?php  echo (isset($owner->email) && $owner->email!='' && $owner->email!=null )?($owner->email):'Not present.'; ?>
		</td>
	</tr>
	</table>
</div>
<button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#demo">
  simple collapsible
</button>

<div id="demo" class="collapse in">Some Div with Some Text.</div>
<style>
    .galleria{ 
        width: 576px;
        height: 432px;
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
});

</script>