<?php
require_once __DIR__ . "/../../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

if (isset($_REQUEST['id'])) {
    $id = strip_tags($_REQUEST['id']);
    $getPoste = $db->prepare('SELECT pos.id as id, pos.Nom as Nom, ent0.Nom as entiteParent0,
     ent1.Nom as entiteParent1, md.mode,
     plmd.listeID as listeID, lis.Nom as listeName
    FROM poste_liste_mode_diffusion as plmd  join Poste as pos on plmd.posteID = pos.id  join
    mode_diffusion as md on (md.id = plmd.modeID) join Liste as lis on (lis.id=plmd.listeID)
    join Entite as ent0 on (pos.Entite = ent0.id) join Entite as ent1 on (ent0.Uper_id=ent1.id)
    and lis.id =:id');
    if ($result = $getPoste->execute(array(':id' => $id))) {
        $row = $getPoste->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        debugScreen($db->errorInfo());
        echo json_encode("erreur");
    }
}