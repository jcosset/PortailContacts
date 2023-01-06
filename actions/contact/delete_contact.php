<?php
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once __DIR__ . "/../../crud/contact/contact.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['conditionWasConfirm'])) {
    if ($_REQUEST['conditionWasConfirm'] == true) {
        $id = strip_tags($_REQUEST['id']);
        deleteContact($id);
        deleteOrphanAddress();
    }
}

debugScreen($_REQUEST);