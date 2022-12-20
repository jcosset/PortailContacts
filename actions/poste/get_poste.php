<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['id'])) {
        $id = strip_tags($_REQUEST['id']);
        $getPoste = $db->prepare('Select id, Nom,Rue, Compl, CP, Ville, Pays, Email_fonctionnel, Entite from Poste 
        where id=:id');
        if($result = $getPoste->execute(array(':id' => $id))){
            $row = $getPoste->fetch( PDO::FETCH_ASSOC );
            echo json_encode($row);
        }else{
            echo json_encode("erreur");
        }
    
}

if (isset($_REQUEST['all'])) {
   
    $sqlFetch = $db->prepare('Select id, Nom,Rue, Compl, CP, Ville, Pays, Email_fonctionnel from Poste');
    
    if($result = $sqlFetch->execute()){
        $rows = $sqlFetch->fetchAll( PDO::FETCH_ASSOC );
        echo json_encode($rows);
    }else{
        echo json_encode("erreur");
    }

}


