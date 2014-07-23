<?php
    /**
     * @var LoginController $this
     * @var CForm           $form
     */
    $this->pageTitle = Yii::t('application', 'Login');
    $this->breadcrumbs = array(
        $this->pageTitle,
    );
?>
<?php
    $form->attributes = array('class' => 'form-horizontal');
    echo $form->renderBegin();
    $widget = $form->activeFormWidget;
?>

<fieldset>
<?php if(isset($partial)) $formLength = 9; else $formLength = 6; ?>
    <div class="form-group <?php echo $widget->error($form, 'username') ? 'has-error' : ''; ?>">
        <?php echo $widget->labelEx($form, 'username', array('class' => 'col-xs-12 col-sm-3 text-right control-label')); ?>
        <div class="col-xs-12 col-sm-<?php echo $formLength; ?>">
            <?php echo $widget->input($form, 'username', array('class' => 'form-control', 'autofocus' => 'true')); ?>
            <?php
                echo $widget->error($form, 'username', array('class' => 'help-block'))
                  ?: $widget->hint($form, 'username', 'div', array('class' => 'help-block'));
            ?>
        </div>
    </div>

    <div class="form-group <?php echo $widget->error($form, 'email') ? 'has-error' : ''; ?>">
        <?php echo $widget->labelEx($form, 'email', array('class' => 'col-xs-12 col-sm-3 text-right control-label')); ?>
        <div class="col-xs-12 col-sm-<?php echo $formLength; ?>">
            <?php echo $widget->input($form, 'email', array('class' => 'form-control')); ?>
            <?php
                echo $widget->error($form, 'email', array('class' => 'help-block'))
                  ?: $widget->hint($form, 'email', 'div', array('class' => 'help-block'));
            ?>
        </div>
    </div>

    <div class="col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-primary')); ?>
    </div>

</fieldset>
<?php echo $form->renderEnd(); ?>