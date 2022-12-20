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

        $stmt = 'Select cont.id as id, addressID, Civilite, Nom , Prenom, Grade, Email, CP, Rue, Ville, Statut,
        Photo, Date_MAJ, TAG, Commentaire, commentaire_niv_2, Poste_actuel as Poste, email_pro, telephone
        from Contact
         where Contact.id =:id';

        $stmt2 = 'select *
        from Contact
        where Contact.id =:id';

        $getContact = $db->prepare($stmt2);


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
         Photo, Date_MAJ, TAG, Commentaire, commentaire_niv_2, Poste_actuel as Poste, email_pro, telephone
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