<?php
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/entite/entite.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['id'])) {
   
        $id = strip_tags($_REQUEST['id']);
        $getEntityById = getEntityById($id);
        if($getEntityById){
            echo json_encode($getEntityById);
        }else{
            echo json_encode("erreur");
        }
    
}

if (isset($_REQUEST['all'])) {
   

   
    $getEntities = getAllEntites();
    if($getEntities){
        echo json_encode($getEntities);
    }else{
        echo json_encode("erreur");
    }

}

