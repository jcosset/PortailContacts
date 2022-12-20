<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['id'])) {
   

        $id = strip_tags($_REQUEST['id']);
        $sqlFetch = $db->prepare('Select * from Entite where id=:id');
        if($result = $sqlFetch->execute(array(':id' => $id))){
            $row = $sqlFetch->fetch( PDO::FETCH_ASSOC );
            echo json_encode($row);
        }else{
            echo json_encode("erreur");
        }
    
}

if (isset($_REQUEST['all'])) {
   

   
    $sqlFetch = $db->prepare('Select * from Entite');
    if($result = $sqlFetch->execute()){
        $row = $sqlFetch->fetchAll( PDO::FETCH_ASSOC );
        echo json_encode($row);
    }else{
        echo json_encode("erreur");
    }

}

