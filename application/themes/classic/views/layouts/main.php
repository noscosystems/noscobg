<?php
    /**
     * @var Controller $this
     */
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf8" />
        <?php
        $bootstrap = Yii::app()->assetManager->publish(Yii::getPathOfAlias('composer.twbs.bootstrap.dist'));
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $bootstrap; ?>/css/bootstrap.min.css" media="all" />
        <!-- <link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes.classic.assets') . '/css/styles.css'); ?>" media="all" /> -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="<?php echo $bootstrap; ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo $bootstrap; ?>/js/galleria/galleria-1.3.6.min.js" type="text/javascript"></script>
        <script src="<?php echo $bootstrap; ?>/js/galleria/plugins/flickr/galleria.flickr.min.js" type="text/javascript"></script>
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
            Smart Properties
        </title>

        <style>
        body {
            background: #FFF;
        }

        a:visited {
            text-decoration: none;
        }
        a:link {
            text-decoration: none;
        }
        a:active {
            text-decoration: none;
        }
        a:hover {
            text-decoration: none;
        }

        .font-raleway {
            font-family: 'Raleway', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        </style>
    </head>

    <body>


        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Smart Properties</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a  href='#' id="goBack" >Go Back</a></li>
                        <li><?php echo CHtml::link('Home', array('/home'), array()); ?></li><!-- 
                        <li><?php //echo CHtml::link('Houses', array('/asset', 'type' => 1), array()); ?></li>
                        <li><?php //echo CHtml::link('Apartments', array('/asset', 'type' => 2), array()); ?></li>
                        <li><?php// echo CHtml::link('Land', array('/asset', 'type' => 3), array()); ?></li> -->
                        <!--<li><?php //echo CHtml::link('Sell', array('/sell')); ?></li> -->
                        <?php if (Yii::app()->user->priv >=50){ ?>
                        <li><?php echo CHtml::link('Create user', array('/admin/user/createuser') ); ?><li>
                        <li><?php echo CHtml::link('Create Asset', array('/admin/asset/index') ); ?></li>
                        <li><?php echo CHtml::link('List users', array('/admin/user/listusers') ); ?></li>
                        <li><?php echo CHtml::link('List Assets', array('/admin/asset/listassets') ); ?></li>
                        <?php }  ?>
                        <li class="dropdown">
                        <?php if( Yii::app()->user->isGuest){ ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Guest <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo CHtml::link('Home', array('/home'), array()); ?></li>
                                <li><?php echo CHtml::link('Login', array('/login'), array()); ?></li>
                            </ul>
                        <?php } else {?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::app()->user->model()->username; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo CHtml::link('Index', array('/admin'), array()); ?></li>
                                <li><?php echo CHtml::link('List Assets', array('/account/listassets'), array()); ?></li>
                                <li><?php echo CHtml::link('Logout', array('/account/logout'), array()); ?></li>
                            </ul>
                        <?php } ?>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="container">
            <?php if(Yii::app()->user->hasFlash('success')): ?>
                <br />
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-success">
                            <?php echo Yii::app()->user->getFlash('success'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            <hr>
                <div class="col-xs-12 text-center">
                    <?php
                        echo Yii::t(
                            'application',
                            'Copyright &copy; {year} by {company}.',
                            array(
                                '{year}' => date('Y'),
                                '{company}' => "Nosco Systems",
                            )
                        );
                    ?>
                    <?php
                        echo Yii::t('application', 'All rights reserved.');
                    ?>
                    <br />
                    <?php
                        $languages = array(
                            'en' => 'English',
                            'cy' => 'Cymraeg',
                        );
                        foreach($languages as $code => &$lang) {
                            $lang = CHtml::link($lang, array('/language', 'lang' => $code));
                        }
                        echo implode(' &middot; ', $languages);
                    ?>
                </div>
            </div>
        </div>
        <script>
            var goBack = document.getElementById('goBack');

            goBack.onclick = function (){
                window.history.back()
            }

        </script>
    </body>

</html>
