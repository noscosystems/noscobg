<?php if(isset($_GET['display'])): ?>
	<div class="alert alert-success">
		<strong>Success!</strong> We loaded this dynamically.
		<br />
		<?php if(isset($id) && $id): ?>
			The id is: <?php echo $id; ?>.
		<?php endif; ?>
	</div>
<?php return; endif; ?>

<div class="jumbotron">
	<div class="container">
		<h1>Load Help</h1>
		<p>In this page I want to load a page, within a page, maybe send some params.</p>
		<p>
			<a id="linkLoad" href="#" class="btn btn-primary btn-lg">Load Data</a>
		</p>
	</div>
</div>

<div id="divLoadArea">I want to load the content here.</div>

<script>
$(document).ready( function(){
	$("#linkLoad").click( function(event){
		event.preventDefault();
		var baseUrl = '<?php echo Yii::app()->urlManager->baseUrl; ?>';
		$("#divLoadArea").load(baseUrl + '/help/load?display&id=2');
	})
})
</script>
