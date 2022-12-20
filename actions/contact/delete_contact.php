<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['conditionWasConfirm'])) {
    if ($_REQUEST['conditionWasConfirm'] == true) {
        $id = strip_tags($_REQUEST['id']);
        $deleteChildrenEntite = $db->prepare('Delete from Contact where id=:id');
        $deleteChildrenEntite->execute(array(':id' => $id));;
    }
}

debugScreen($_REQUEST);