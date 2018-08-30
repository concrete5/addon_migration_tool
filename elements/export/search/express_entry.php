<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$r = Database::get()->getEntityManager()->getRepository('Concrete\Core\Entity\Express\Entity');
$entities = array();
foreach($r->findAll() as $entity) {
    $entities[$entity->getID()] = $entity->getName();
}
$form = Core::make('helper/form');
?>
<div class="form-group">
    <?=$form->label('id', t('Express Object'))?>
    <?=$form->select('id', $entities)?>
</div>