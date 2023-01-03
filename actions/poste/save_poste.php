<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);

$nom = strip_tags($_POST['nom']);
$rue = strip_tags($_POST['rue']);
$complement = strip_tags($_POST['complement']);
$cp = strip_tags($_POST['cp']);
$ville = strip_tags($_POST['ville']);
$pays = strip_tags($_POST['pays']);
$email = strip_tags($_POST['email']);
$entiteId = strip_tags($_POST['entiteId']);

$stmt = $db->prepare('INSERT INTO Poste (Nom, Rue, Compl, CP, Ville, Pays, Email_fonctionnel, Entite)
     VALUES (:nom, :rue, :complement,:cp, :ville, :pays, :email, :entiteId)');

if ($stmt->execute(array(
  ':nom' => $nom, ':rue' => $rue, ':complement' => $complement, ':cp' => $cp, ':ville' => $ville,
  ':pays' => $pays, 'email' => $email, ':entiteId' => $entiteId
))) {
  echo "SAVE";
} else {
  echo "error";
}