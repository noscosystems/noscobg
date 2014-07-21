<?php
    /**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath);
    $form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
    echo $form->renderBegin();
    $widget = $form->activeFormWidget;

    if($widget->errorSummary($form)){
        echo '<div class="alert alert-danger">' . $widget->errorSummary($form) . '</div>';
    }
?>
 <div class="row" id="fail"> 
 </div>
<?php if(Yii::app()->user->hasFlash('del_success')): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo Yii::app()->user->getFlash('del_success'); ?>
    </div>
<?php endif;?>

<?php if(Yii::app()->user->hasFlash('del_failed')): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo Yii::app()->user->getFlash('del_failed'); ?>
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
                <!-- <td class="text-right"><?php //echo CHtml::link(($v->active == 1)?'Ianctive':'Active', array('/admin/user/deleteuser', 'id' => $v->id ),array('class' => ($v->active == 1)?'btn btn-danger btn-xs':'btn btn-primary btn-xs')); ?></td> -->
                <td class="text-right"><button value="<?php echo $v->id; ?>" class="btn btn-danger btn-xs" onclick="return send(this)">Inactive</button></td>
                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('CLinkPager', array('pages' => $pages)); ?>
<?php echo $form->renderEnd(); ?>
<script>


function send(button){
//var butt = document.getElementById('butt');
    var fail = document.getElementById('fail');
    var fail_msg ='<div class="alert alert-danger">'
                +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                +'You do not have the required privilige level for this command.'
            +'</div>';
    var xmlhttp = httpReq();
    do {
        xmlhttp.open('POST','<?php echo Yii::app()->baseUrl; ?>'+'/admin/user/deleteuser',false);
        xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        xmlhttp.send('id='+button.value+'&butt_value='+button.innerHTML);
    }while (xmlhttp.readyState!=4 && xmlhttp.status!=200);
    if (xmlhttp.readyState==4 && xmlhttp.status==200){
        (xmlhttp.responseText == 'Active')
        ?(button.className = 'btn btn-xs btn-primary')
        :((xmlhttp.responseText == 'Inactive')
        ?
        (button.className = 'btn btn-xs btn-danger')
        :(fail.innerHTML = fail_msg));
        button.innerHTML = xmlhttp.responseText;
    }
    return false;
}

function httpReq(){
    var xmlhttp;
    return xmlhttp=(window.XMLHttpRequest)?(new XMLHttpRequest()):(new ActiveXObject('Microsoft.XMLHTTP'));
}
</script>



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