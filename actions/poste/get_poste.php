<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['id'])) {
    $id = strip_tags($_REQUEST['id']);
    $getPoste = $db->prepare('Select id, Nom,Rue, Compl, CP, Ville, Pays, Email_fonctionnel, Entite from Poste
        where id=:id');
    if ($result = $getPoste->execute(array(':id' => $id))) {
        $row = $getPoste->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode("erreur");
    }
}

if (isset($_REQUEST['all'])) {

    "SELECT Poste.id, Poste.Nom, ent0.Nom as 'entiteParent0',  ent1.Nom as 'entiteParent1'
    from Poste join Entite as ent0 on (Poste.Entite = ent0.id) join Entite as ent1 on (ent0.Uper_id=ent1.id)";

    $sqlFetch = $db->prepare("Select pos.id, ent0.Nom as 'entiteParent0',  ent1.Nom as 'entiteParent1', pos.Nom,Rue, Compl, CP, Ville, Pays, Email_fonctionnel from Poste as pos
     join
    Entite as ent0 on (pos.Entite = ent0.id) join Entite as ent1 on (ent0.Uper_id=ent1.id)
    ");

    if ($result = $sqlFetch->execute()) {
        $rows = $sqlFetch->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } else {
        echo json_encode("erreur");
    }
}