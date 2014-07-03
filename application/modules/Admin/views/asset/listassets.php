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
  <h1>Assets <small>Below is a list of all users.</small></h1>
</div>

<div class="form-group">
    <div class="col-sm-10">
        <?php echo $widget->input($form, 'search', array('class' => 'form-control', 'title' => 'Type in a username to find a user') ); //echo '<br>';?>
    </div>
    <div class="col-sm-2">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-sm btn-success  form-control', 'value' => 'Find Asset') ); ?>
    </div>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Name of asset</th>
			<th>Link to edit page</th>
            <th>Images</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach($assets as $v): ?>
            <tr>
                <td><?php echo $v->name; ?></td>
                <td><?php echo CHtml::link($v->name, array('/admin/asset/editasset', 'id' => $v->id ),array('title' => 'Click to edit a user.')); ?></td>
                <td><?php echo CHtml::link('View', array('/admin/asset/images', 'id' => $v->id ),array('title' => 'Click to view images related to this asset.')); ?></td>
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