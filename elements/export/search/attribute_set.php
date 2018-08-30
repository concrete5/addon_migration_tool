<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Core::make('helper/form');
$categories = array();
$list = \Concrete\Core\Attribute\Key\Category::getList();
foreach ($list as $category) {
    $categories[$category->getAttributeKeyCategoryID()] = $category->getAttributeKeyCategoryHandle();
}
?>
<div class="form-group">
    <?=$form->label('category', t('Attribute Category'))?>
    <?=$form->select('akCategoryID', $categories)?>
</div>