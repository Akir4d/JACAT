<?php

//Start counting the buttons that we have:
$buttons_counter = 0;

if (!$unset_edit) {
    $buttons_counter++;
}

if (!$unset_read) {
    $buttons_counter++;
}

if (!$unset_delete) {
    $buttons_counter++;
}

if (!$unset_clone) {
    $buttons_counter++;
}

if (!empty($list[0]) && !empty($list[0]->action_urls)) {
    $buttons_counter += count($list[0]->action_urls);
}
?>
<style>
    .margin-stop {
        margin-top: 0;
        margin-bottom: 0;
    }
</style>
<table cellpadding="0" cellspacing="0" border="0" class="groceryCrudTable table" id="<?php echo uniqid(); ?>">
</table>