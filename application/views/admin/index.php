<?php
    /**
     * @var AdminController $this
     */
    $this->pageTitle = false;
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>


<div>
  <p style="text-align:center;"> Sample admin page</p>
  <table>
  <tr>
    <td><input value="Name of asset" class="inp_label"></td>
    <td><input name="name" type="text"></td>
  </tr>
  <tr>
    <td><input value="Area of asset" type="text" class="inp_label"></td>
    <td><input name="area" type="text"></td>
  </tr>
  <tr>
    <td><input value="Type of asset" type="text" class="inp_label"></td>
    <td><input name="type" type="text"></td>
  </tr>
  <tr>
    <td><input value="Rent for a day" type="text" class="inp_label"></td>
    <td><input name="rent_day" type="text"></td>
  </tr>
  <tr>
    <td><input value="Rent for a week" type="text" class="inp_label"></td>
    <td><input name="rent_week" type="text"></td>
  </tr>
  <tr>
    <td><input value="Rent for a month" type="text" class="inp_label"></td>
    <td><input name="rent_month" type="text"></td>
  </tr>
  <tr>
    <td><input value="Price_of_asset" type="text" class="inp_label"></td>
    <td><input name="price" type="text"></td>
  </tr>
  </table>
</div>
<style>
.inp_label{
  background:transparent;
  border:none;
}
</style>