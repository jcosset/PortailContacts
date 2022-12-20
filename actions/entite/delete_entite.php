<?php

if (isset($_REQUEST['conditionWasConfirm'])) {
    if($_REQUEST['conditionWasConfirm'] == true){
        $id = strip_tags($_REQUEST['id']);
        $deleteChildrenEntite = $db->prepare('Delete from Entite where Uper_id=:id');
        $deleteChildrenEntite->execute(array(':id' => $id));

        $deleteEntite = $db->prepare('Delete from Entite where id=:id');
        $deleteEntite->execute(array(':id' => $id));
    }
	
	

}




?>