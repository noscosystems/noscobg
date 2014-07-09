<?php
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>

<div style="margin-left: -20px; width: 105%; z-index: 100;" id="image-cycle" class="carousel slide" data-pause="carousel" data-interval="4000" data-wrap="true">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#image-cycle" data-slide-to="0" class="active"></li>
        <li data-target="#image-cycle" data-slide-to="1"></li>
        <!-- <li data-target="#image-cycle" data-slide-to="2"></li> -->
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="<?php echo $assetUrl; ?>/images/varna1.png" width="100%" style="height:100%">
            <div class="carousel-caption">
                <h1></h1>
                <br />
            </div>
        </div>

        <div class="item">
            <img src="<?php echo $assetUrl; ?>/images/varna2.png" width="100%" style="height:100%">
            <div class="carousel-caption">
                <h1></h1>
                <br />
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#image-cycle" data-slide="prev" class="getMyClick">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#image-cycle" data-slide="next" class="getMyClick">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<table>
    <tr>
        <td class="items">
            <img src="<?php echo $assetUrl; ?>/images/varna1.png" width="320" height="240">
        </td>
        <td class="items">
            <img src="<?php echo $assetUrl; ?>/images/varna2.png" width="320" height="240">
        </td>
    </tr>
</table>
<style>

    .mark{
        border:solid red;
    }

</style>
<script>
    var elements = document.getElementsByClassName('item');
    var items = document.getElementsByClassName('items');
    var leftClick= document.getElementsByClassName('getMyClick');

    leftClick.onclick = function () {
        for ( var i=0; i<elements.length; i++ ){
            if (elements[i].indexOf('active')){
                for (var j=0; j<items.length; j++){
                    if (i==j){
                        items[j].className = items[j].className + ' mark';
                    }
                }
            }
        }
    }
</script>