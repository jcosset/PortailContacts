<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);
if (isset($_POST['id'])) {
  $id = strip_tags($_POST['id']);
  $nom = strip_tags($_POST['nom']);
  $rue = strip_tags($_POST['rue']);
  $complement = strip_tags($_POST['complement']);
  $cp = strip_tags($_POST['cp']);
  $ville = strip_tags($_POST['ville']);
  $pays = strip_tags($_POST['pays']);
  $email = strip_tags($_POST['email']);
  $entiteId = strip_tags($_POST['entiteId']);

  $stmt = $db->prepare('UPDATE Poste SET Nom=:nom, Rue=:rue, Compl=:complement, CP=:cp, Ville=:ville, Pays=:pays,
    Email_fonctionnel=:email, Entite=:entiteId where id=:id');
  debugScreen($stmt);
  $result =  $stmt->execute(array(
    ':nom' => $nom, ':rue' => $rue, ':complement' => $complement, ':cp' => $cp, ':ville' => $ville,
    ':pays' => $pays, ':email' => $email, ':entiteId' => $entiteId, ':id' => $id
  ));

  if ($result) {
    echo "success";
  } else {
    echo "error";
  }
}