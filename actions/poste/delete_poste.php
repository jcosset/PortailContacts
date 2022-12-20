<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['conditionWasConfirm'])) {
    if ($_REQUEST['conditionWasConfirm'] == true) {

        $id = strip_tags($_REQUEST['id']);
        $deletePoste = $db->prepare('Delete from Poste where id=:id');
        $deletePoste->execute(array(':id' => $id));
    }
}
debugScreen($_REQUEST);
