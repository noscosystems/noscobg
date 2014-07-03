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

<?php if(Yii::app()->user->hasFlash('del_success')): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo Yii::app()->user->getFlash('del_success'); ?>
    </div>
<?php endif;?>

<div class="page-header">
  <h1>View users <small>Below is a list of all users.</small></h1>
</div>

<div class="form-group">
    <div class="col-sm-10">
        <?php echo $widget->input($form, 'search', array('class' => 'form-control', 'title' => 'Type in a username to find a user') ); //echo '<br>';?>
    </div>
    <div class="col-sm-2">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-sm btn-success  form-control') ); ?>
    </div>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>username</th><th>current privilige</th><th class="text-right">Link to edit page</th><th class="text-right">Delete user</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach($users as $v): ?>
            <tr>
                <td><?php echo $v->username; ?></td>
                <td><?php echo $v->priv; ?></td>
                <td class="text-right"><?php echo CHtml::link('Edit User', array('/admin/user/', 'id' => $v->id ),array('class' => 'btn btn-xs btn-warning', 'title' => 'Click to edit a user.')); ?></td>
                <td class="text-right"><?php echo CHtml::link('Delete', array('/admin/user/deleteuser', 'id' => $v->id ),array('class' => 'btn btn-danger btn-xs', 'title' => 'Click to delete a user.')); ?></td>
            </tr>
        <?php endforeach; ?>
	</tbody>
</table>
<?php $this->widget('CLinkPager', array('pages' => $pages)); ?>
<?php echo $form->renderEnd(); ?>

 <?php
//  $this->widget('zii.widgets.CListView', array(
//     'dataProvider' => $dataProvider,
//     'itemView' => '_index',
//     'ajaxUpdate'=>false,
//     'enablePagination'=>false,
//     'pagerCssClass' => 'result-list',
//     'summaryText' => 'Total '. $pagination->itemCount .' Results Found',
// ));
// $this->widget('CLinkPager', array(
//     'header' => '',
//     'firstPageLabel' => '&lt;&lt;',
//     'prevPageLabel' => '&lt;',
//     'nextPageLabel' => '&gt;',
//     'lastPageLabel' => '&lt;&lt;',
//     'pagination' => $pagination,
// ));
// ?>