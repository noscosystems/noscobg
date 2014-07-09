<?php 
    use \application\models\db\Images;
?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <?php if (isset($_GET['id']) && !empty ($_GET['id'])){
                            $image = Images::model()->findByAttributes(array ('asset' => $_GET['id']));
                            echo CHtml::image(Yii::app()->assetManager->publish($image->url), $image->asset,array('class' => 'img-rounded',
                                    'height' => '240',
                                    'width' => '300'));
                        }
                        ?>
                    </div>
                    <div class="col-sm-8">
                        <div class="jumbotron">
                            <?//php $form->attributes=array('class' => 'form-horizontal','enctype' => 'multipart/form-data');
                            //echo $form->renderBegin();
                            //$widget = $form->activeFormWidget; ?>
                            <div class="container">
                                <h1>Upload</h1>
                                <p>Upload your image here</p>
                                <p>
                                    <input name="image1" type="file" class="btn btn-primary btn-lg">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Take me to your leader</button>
            </div>
        </div>
    </div>
</div>
