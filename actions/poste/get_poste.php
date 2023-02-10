<?php
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/poste/poste.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once __DIR__ . "/../../crud/poste/poste.php";

if (isset($_REQUEST['id'])) {
    $id = strip_tags($_REQUEST['id']);
    $getPoste = getPosteById($id); 
    if ($getPoste) {
        echo json_encode($getPoste);
    } else {
        echo json_encode("erreur");
    }
}

if (isset($_REQUEST['all'])) {

    "SELECT Poste.id, Poste.Nom, ent0.Nom as 'entiteParent0',  ent1.Nom as 'entiteParent1'
    from Poste join Entite as ent0 on (Poste.Entite = ent0.id) join Entite as ent1 on (ent0.Uper_id=ent1.id)";

    $sqlFetch = $db->prepare("Select pos.id, ent0.Nom as 'entiteParent0',  ent1.Nom as 'entiteParent1', pos.Nom,Rue, Compl, CP, Ville, Pays, Email_fonctionnel from Poste as pos
        join Entite as ent0 on (pos.Entite = ent0.id) 
        left join Entite as ent1 on (ent0.Uper_id=ent1.id)
    ");

    if ($result = $sqlFetch->execute()) {
        $rows = $sqlFetch->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } else {
        echo json_encode("erreur");
    }
}

if (isset($_REQUEST['all_filtered'])) {

    $getPostes = getAllPostes();
    if ($getPostes) {
        echo json_encode($getPostes);
    } else {
        echo json_encode("erreur");
    }
}
