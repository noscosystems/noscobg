<?php
// Yii has a widget for rendering pagination links. Let's use it because we're lazy and can't be bothered to
// write our own :)
$this->widget('CLinkPager', array(
    'currentPage' => $pagination->currentPage,
    'firstPageLabel' => '&#171;',
    'footer' => false,
    'header' => false,
    'hiddenPageCssClass' => 'disabled',
    'htmlOptions' => array('class' => 'pagination'),
    'itemCount' => $pagination->itemCount,
    'lastPageLabel' => '&#187;',
    'nextPageLabel' => '&#8250;',
    'pageSize' => $pagination->pageSize,
    'prevPageLabel' => '&#8249;',
    'selectedPageCssClass' => 'active',
));
?>
