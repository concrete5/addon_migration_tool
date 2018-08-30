<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Word')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getWords() as $word) {
    $validator = $word->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$word->getWord()?></td>
            <td><input data-checkbox="select-item" type="checkbox" name="item[banned_word][]" value="<?=$word->getID()?>"></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
