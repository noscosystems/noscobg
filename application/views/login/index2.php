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

    <div class="form-group <?php echo $widget->error($form, 'password') ? 'has-error' : ''; ?>">
        <?php echo $widget->labelEx($form, 'password', array('class' => 'col-xs-12 col-sm-3 text-right control-label')); ?>
        <div class="col-xs-12 col-sm-<?php echo $formLength; ?>">
            <?php echo $widget->input($form, 'password', array('class' => 'form-control')); ?>
            <?php
                echo $widget->error($form, 'password', array('class' => 'help-block'))
                  ?: $widget->hint($form, 'password', 'div', array('class' => 'help-block'));
            ?>
        </div>
    </div>

    <div class="col-sm-offset-3">
        <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link('Forgotten Password', array('/forgot'), array('class' => 'btn btn-link')); ?>
    </div>

</fieldset>
<?php echo $form->renderEnd(); ?>