<?php
/*
This file should explain roughly how to use forms with the view.
This page will not work in the browser.
*/
?>

<?php
// Start by rendering the form in both PHP and Html
// This will apply any html attributes that you want to apply
$form->attributes = array('class' => 'form-horizontal');
// This will then render the form tag with any attributes either set in the configuration or the line about.
echo $form->renderBegin();
// Finally, use the widget for the PHP side of the form, the widget is used to render properties.
$widget = $form->activeFormWidget;
?>

    <?php 
    // You can display an input field by using the syntax below:
    echo $widget->input($formVariable, 'nameOfElement', array('htmlOption' => 'htmlValue')); 
    // The line below is an example of displaying the first name field.
    echo $widget->input($form, 'firstname', array('class' => 'form-control', 'placeholder' => 'First Name'));
    ?>

    <?php 
    // To display a submit button, use the following syntax:
    echo $widget->button($formVariable, 'nameOfButton', array('htmlOption' => 'htmlValue'));
    // And here is an example of how the button would be using some bootstrap class too.
    echo $widget->button($form, 'submit', array('class' => 'btn btn-block btn-success', 'value' => 'Save!'));
    ?>

<?php 
// Last but not least, you have to always specify the end of the form.
// This is like having a </form> closing tag. It will also close the widget.
echo $form->renderEnd();
?>