
<?php
    /**
     * @var HomeController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>

<head>
    <meta charset="utf8" />
    <?php
    $bootstrap = Yii::app()->assetManager->publish(Yii::getPathOfAlias('composer.twbs.bootstrap.dist'));
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $bootstrap; ?>/css/bootstrap.min.css" media="all" />
    <!-- <link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes.classic.assets') . '/css/styles.css'); ?>" media="all" /> -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="<?php echo $bootstrap; ?>/js/bootstrap.min.js"></script>
    <link href="<?php echo $bootstrap; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />

    <!-- Blueprint CSS Framework. -->
    <link href="<?php echo $assetUrl; ?>/css/screen.css" rel="stylesheet" type="text/css" media="screen, projection" />
    <link href="<?php echo $assetUrl; ?>/css/print.css" rel="stylesheet" type="text/css" media="print" />
    <!--[if lt IE 8]>
        <link href="<?php echo $assetUrl; ?>/css/ie.css" rel="stylesheet" type="text/css" media="screen, projection" />
    <![endif]-->
    <link href="<?php echo $assetUrl; ?>/css/main.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo $assetUrl; ?>/css/form.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Document Meta Title. -->
    <title>
    	Properties store
        <?php
            /*if(is_string($this->pageTitle) && $this->pageTitle) {
                echo CHtml::encode($this->pageTitle) . ' &#8212; ';
            }
            echo CHtml::encode(Yii::app()->name);*/
        ?>
    </title>
</head>
<div style="top:5; left:5; position:absolute; z-index:200;" >Logo</div>
<div style="top:5; right:5; position:absolute; z-index:200;">
  	<h1>
		<a href="#" >My HREF 1</a>
		<a href="#" >My HREF 2</a>
		<a href="#" >My HREF 3</a>
    </h1>
</div>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <!-- <li data-target="#carousel-example-generic" data-slide-to="2"></li> -->
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" style="height:33%;">
    <div class="item active" style="height:inherit;">
      <img src="/noscobg/application/themes/classic/assets/images/first.jpg" alt="" style="width:100%;">
      <div class="carousel-caption" style="color:black;">
        
      </div>

    </div>
    <div class="item">
      <img src="/noscobg/application/themes/classic/assets/images/second.jpg" alt="" style="width:100%;">
      <div class="carousel-caption">
        My Caption
     </div>

    </div>
    ...
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
<div style="background:#333; width:100%; height:150px; padding-top:5%;  text-align:center;">
Search
</div>
<div style="padding-top:5%; width:90%; text-align:center; background:#CCC; margin: 0 5% 0 5%; height:33.3%;">
	Search results
</div>
<div id="footer">
Copyright &copy; 2014 by noscobg
</div>