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
			<div class="row">
				<div class="col-sm-4">
					<input type="text" id="inputText" class="form-control" placeholder="Add text here.">
				</div>
				<div class="col-sm-8">
					<a id="linkLoad" href="#" class="btn btn-primary btn-md">Load Data</a>
				</div>
			</div>
		</p>
	</div>
</div>

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
