<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";


$response = [
    'success' => false,
    'data' => [],
    'error' => '',
];

if (isset($_REQUEST['id'])) {

    $id = strip_tags($_REQUEST['id']);

    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "default") {

        $stmt = 'SELECT con.id,`Civilite`, `Nom`,`Prenom`,`Grade`,`Email`,`Statut`,`Photo`,`Poste_actuel`, `date_debut`, `Date_MAJ`,`TAG`,`Commentaire`,`telephone`,`email_pro`,`commentaire_niv_2`,`addressID`, `Rue`, `Compl`, `CP`, `Ville`, `Pays`
        FROM `Contact` as con
        left Join `address` as addr on addr.id = con.addressID
        where con.id =:id';

        $getContact = $db->prepare($stmt);


        if ($result = $getContact->execute(array(':id' => $id))) {
            $row = $getContact->fetch(PDO::FETCH_ASSOC);
            if ($row['addressID'] == null || $row['addressID'] == "null") {
                $row["Rue"] = null;
                $row["CP"] = null;
                $row["Ville"] = null;
                $row["Pays"] = null;
                $row["Compl"] = null;
            }
            echo json_encode($row);
        } else {
            print_r($db->errorInfo());
            echo json_encode("erreur");
        }
    } else {

        $getContact = $db->prepare('Select Contact.id as id, addressID, Civilite, Contact.Nom as Nom, Prenom, Grade, Email, Statut,
         Photo, Date_MAJ, TAG, Commentaire, commentaire_niv_2, Poste_actuel as Poste, date_debut, email_pro, telephone
         from Contact join Poste as pos on (Contact.Poste_actuel=pos.id) and Contact.id =:id');
        if ($result = $getContact->execute(array(':id' => $id))) {
            $row = $getContact->fetch(PDO::FETCH_ASSOC);
            http_response_code(200);
            echo json_encode($row);
        } else {
            http_response_code(400);
            echo json_encode("erreur");
        }
    }
}