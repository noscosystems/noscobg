
<?php echo CHtml::link('Open Modal', '#myModal', array('class' => 'btn btn-md btn-primary', 'data-toggle' => 'modal')); ?>

<?php $this->renderPartial('//modals/help'); ?>
<div id="divLoadArea">I want to load the content here.</div>
<script>
$(document).ready( function(){
	$("#linkLoad").click( function(event){
		event.preventDefault();
		var baseUrl = '<?php echo Yii::app()->urlManager->baseUrl; ?>';
		var inputText = $("#inputText").val();
		$("#divLoadArea").load(baseUrl + '/help/load?display&id=' + inputText);
	})
})
</script>
