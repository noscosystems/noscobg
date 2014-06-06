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

    <body>
        <div class="container" id="page">

            <div id="header">
                <div id="logo">
                    <?php echo CHtml::encode(Yii::app()->name); ?>
                </div>
            </div>

            <div id="mainmenu">
                <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array('label' => Yii::t('application', 'Home'), 'url' => Yii::app()->homeUrl),
                            array('label' => Yii::t('application', 'Login'), 'url' => array('/login'), 'visible' => Yii::app()->user->isGuest),
                            array(
                                'label' => Yii::t(
                                    'application',
                                    'Logout ({name})',
                                    array('{name}' => Yii::app()->user->name)
                                ),
                                'url' => array('/logout'),
                                'visible' => !Yii::app()->user->isGuest,
                            ),
                        ),
                    ));
                ?>
            </div>
            <!-- Breadcrumbs. -->
            <?php
                if(isset($this->breadcrumbs) && is_array($this->breadcrumbs) && !empty($this->breadcrumbs)) {
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                    ));
                }
            ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                <?php
                    echo Yii::t(
                        'application',
                        'Copyright &copy; {year} by {company}.',
                        array(
                            '{year}' => date('Y'),
                            '{company}' => Yii::app()->name,
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
                <br />
                <?php echo Yii::powered(); ?>
            </div>

        </div>
    </body>

</html>
