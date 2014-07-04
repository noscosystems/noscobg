<?php
    /**
     * @var AssetController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');



?>
<style>
table tr td:hover {
	background-color: #e8e8e8;
}
</style>
<?php
$form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data', 'id' => 'frm');
echo $form->renderBegin();
$widget = $form->activeFormWidget;
?>


<input type='text' class='text'>
<input type='text' class='text'>
<table class="table">
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
						<input name="image1" type="file" class="files">
					</td>
			
		<?php endforeach; ?>
				</tr>
	</tbody>
</table>

<!-- $widget = $form->activeFormWidget; -->
<?php echo $widget->input($form, 'asset', array('class' => 'form-control' , 'value' => $_GET['assetname']) ); ?>
<?php echo $form->renderEnd(); ?>

<script>
	var files = document.getElementsByClassName("file");
	var form = document.getElementById('frm');
	var txt = document.getElementsByClassName('text');
	function change(){
		var form = document.getElementById('frm');
		form.submit();
	}

	// for (var i=0; i<files.length; i++){
	txt.onchange = function () {
			// var httpreq = New XMLHttpRequest;
			// httpreq.open("POST","http://localhost/noscobg/public_html/admin/asset/images",true);
			// httpreq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			// httpreq.send("fname=Henry&lname=Ford");
			// alert (txt[i].value);
			form.submit();
	// 	}
	}
</script>