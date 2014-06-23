<?php
	/**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
    $form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
    echo $form->renderBegin();
    $widget = $form->activeFormWidget;



    if($widget->errorSummary($form)){
        echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
    }
?>
<div class="page-header">
  <h1>View users <small>Below is a list of all users.</small></h1>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Asset Name</th><th>Current privilige</th><th>Select new privilige</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach($users as $v): ?>
            <tr>
                <td><?php echo $v->username; ?></td>
                <td><?php echo $v->priv; ?></td>
                <td><?php echo $widget->input($form, 'priv[]', array('class' => 'form-control') ); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">
                <div align="right">
                <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-lg btn-success',) ); ?>
                </div>
            </td>
        </tr>
	</tbody>
</table>
<?php echo $form->renderEnd(); ?>