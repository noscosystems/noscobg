
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

    <link  href='http://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>

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
    <style>
    .navigation {
        top: 5;
        left: 5;
        z-index: 200;
        position: absolute;
        width: 100%;
        padding: 20px;
    }

    .logo {
        margin-top: 10px;
        margin-left: 10px;
    }

    .links {
        color: #FFF;
        text-shadow: 1px 1px #444;
        text-transform: uppercase;
        font-size: 2em;
        text-decoration: none;
        margin-top: 15px;
    }

    .links a:visited {
        color: #FFF;
        margin-left: 15px;
        text-decoration: none;
    }
    .links a:link {
        color: #FFF;
        margin-left: 15px;
        text-decoration: none;
    }
    .links a:active {
        color: #FFF;
        margin-left: 15px;
        text-decoration: none;
    }
    .links a:hover {
        color: #FFF;
        text-decoration: none;
    }

    .search {
        background: #333;
        width: 100%;
        height: 150px;
        padding-top: 20px;
        color: #FFF;
        -webkit-box-shadow: 0px 0px 8px 2px #444444;
           -moz-box-shadow: 0px 0px 8px 2px #444444;
                box-shadow: 0px 0px 8px 2px #444444;
        z-index: 150;
    }

    .searchResults {
        background: #CCC;
        /*width: 100%;*/
        /*height: 150px;*/
        /*padding-top: 20px;*/
        color: #999;
        z-index: 130;
    }

    .font-raleway {
        font-family: 'Raleway', sans-serif;
        -webkit-font-smoothing: antialiased;
    }
    </style>
</head>

<div class="navigation">
    <div class="pull-left">
        <div class="logo">
            <img src="<?php echo $assetUrl; ?>/images/logo1.png">
        </div>
    </div>

    <div class="pull-right font-raleway links">
        <?php echo CHtml::link('Home', array('/home'), array()); ?>
        <?php echo CHtml::link('Houses', array('/asset', 'type' => 1), array()); ?>
        <?php echo CHtml::link('Apartments', array('/asset', 'type' => 2), array()); ?>
        <?php echo CHtml::link('Land', array('/asset', 'type' => 3), array()); ?>
        <?php echo CHtml::link('Sell', array('/sell')); ?>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">User <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><?php echo (Yii::app()->user->isGuest)?(CHtml::link('Register', array('account/register'), array())):'';?></li>
                <li><?php echo (!Yii::app()->user->isGuest)?(CHtml::link('My Account', array('/account/myaccount'), array())):'';?></li>
                <li><?php echo (!Yii::app()->user->isGuest)?(CHtml::link('My Assets', array('/account/listassets'), array())):''; ?></li>
                <?php echo (Yii::app()->user->priv>=50)?( '<li>'.CHtml::link('Admin', array('/admin')).'</li>'):''; ?>
                <li><?php echo (Yii::app()->user->isGuest)?(CHtml::link('Guest\Login', array('/login'), array())):CHtml::link('Log Out', array('/account/logout'), array()); ?></li>
                <!-- CHtml::link('Myaccount', array('account/myaccount'), array()) -->
            </ul>

    </div>
    </div>




<div style="margin-left: -20px; width: 105%; z-index: 100;" id="image-cycle" class="carousel slide" data-ride="carousel" data-interval="4000" data-wrap="true">
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
    <a class="left carousel-control" href="#image-cycle" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#image-cycle" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>




<div class="search row">
    <div class="col-md-6 col-md-offset-3">
        <?php
            // $form->attributes = array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data');
            // $form->renderBegin ();
            // $widget = $form->activeFormWidget();
            // $form->renderEnd();
        ?>
    </div>

<?php //if($widget->errorSummary($form)): ?>
    <!-- <div class="alert alert-danger"> -->
        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
        <?php //echo $widget->errorSummary($form); ?>
    <!-- </div> -->
<?php //endif; ?>
   <!--  <div class="container">
        Search
    </div> -->
</div>


<div class="searchResults col-md-10 col-md-offset-1">
    <?php foreach ($randAssets as $asset ): ?>
    <br>
        <div class="row">
            <?php $images = ($asset)?($asset->Images):''; ?>
            <div class="col-md-3">
                <?php $image = $asset->Images; ?>
                <?php echo (isset ($image) && count($image) > 0 )?
                (CHtml::image(Yii::app()->assetManager->publish($image[0]->url), $image[0]->asset,
                    array(
                        'class' => 'img-responsive',
                        'height' => '240',
                        'width' => '300'
                        ))
                        )
                        :'';?>
            </div>
            <div class="col-md-8">
                <p>
                    <?php echo $asset->name; ?>
                </p>
            </div>
            <div class="col-md-1">
                <?php echo CHtml::link('Details', array('/asset/details'), array('class' => 'btn btn-danger')); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
