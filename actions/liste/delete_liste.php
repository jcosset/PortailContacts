<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['conditionWasConfirm'])) {
    if ($_REQUEST['conditionWasConfirm'] == true) {
        $id = strip_tags($_REQUEST['id']);
        $deleteListe = $db->prepare('Delete from Liste where id=:id');
        $deleteListe->execute(array(':id' => $id));

        $deleteListeModeDiff = $db->prepare('Delete from liste_mode_diffusion where listeID=:id');
        $deleteListeModeDiff->execute(array(':id' => $id));

        $deletePosteListeModeDiff = $db->prepare('Delete from poste_liste_mode_diffusion where listeID=:id');
        $deletePosteListeModeDiff->execute(array(':id' => $id));
    }
}
debugScreen($_REQUEST);