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
            background: #FEFEFE;
        }

        .navigation {
            top: 0;
            left: 0;
            position: absolute;
            width:100%;
            background: #CCC;
            padding-bottom: 5px;
            /*-webkit-box-shadow: 0px 0px 8px 2px #AAA;*/
               /*-moz-box-shadow: 0px 0px 8px 2px #AAA;*/
                    /*box-shadow: 0px 0px 8px 2px #AAA;*/
        }

        .logo {
            margin-top: 10px;
            margin-left: 10px;
        }

        .links {
            color: #444;
            text-shadow: 0px 1px #EEE;
            text-transform: uppercase;
            font-size: 1.2em;
            text-decoration: none;
            margin-top: 26px;
        }

        .links a:visited {
            color: #444;
            margin-left: 15px;
            text-decoration: none;
        }
        .links a:link {
            color: #444;
            margin-left: 15px;
            text-decoration: none;
        }
        .links a:active {
            color: #444;
            margin-left: 15px;
            text-decoration: none;
        }
        .links a:hover {
            color: #555;
            text-decoration: none;
            background: #c5c5c5;
        }

        .font-raleway {
            font-family: 'Raleway', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        #content {
            background: #EFEFEF;
        }
        </style>
    </head>

    <body>
        <div class="navigation">
            <div class="container">

                <div class="pull-left">
                    <div class="logo">
                        <img src="<?php echo $assetUrl; ?>/images/logo1.png">
                    </div>
                </div>

                <div class="pull-right">
                    <div class="font-raleway links">
                        <?php echo CHtml::link('Home', array('/home'), array()); ?>
                        <?php echo CHtml::link('Houses', array('/asset', 'type' => 1), array()); ?>
                        <?php echo CHtml::link('Apartments', array('/asset', 'type' => 2), array()); ?>
                        <?php echo CHtml::link('Land', array('/asset', 'type' => 3), array()); ?>
                        <?php echo CHtml::link('Admin', array('/admin'), array()); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="content">

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
    </body>

</html>
