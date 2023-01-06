<?php
require_once __DIR__."/../../config.php";
require_once __DIR__."/../../crud/address/address.php";
require_once __DIR__."/../../crud/entite/entite.php";
require_once SITE_ROOT."/inc/helpers/debug.php";

if (isset($_REQUEST['conditionWasConfirm'])) {
    if($_REQUEST['conditionWasConfirm'] == true){
        $id = strip_tags($_REQUEST['id']);
        $deleteChildrenEntite = $db->prepare('Delete from Entite where Uper_id=:id');
        $deleteChildrenEntite->execute(array(':id' => $id));

        deleteEntite($id);
        deleteOrphanAddress();
    }
	
	

}




?>