<?php
include 'inc/db.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function get_contacts(){
    require('inc/db.php');
    $sqlRecupContacts = "SELECT Nom, Prenom, Grade, Email, Statut, Poste_actuel FROM Contact ORDER BY Nom";
     $queryRecupContacts = $db->prepare( $sqlRecupContacts );
     $queryRecupContacts->execute();
     $resultRecupContacts = $queryRecupContacts->fetchAll( PDO::FETCH_ASSOC );
     return $resultRecupContacts;
}

$listecontacts = get_contacts();
foreach ($listecontacts as $contact) {
    echo $contact['Nom'];
}
?>