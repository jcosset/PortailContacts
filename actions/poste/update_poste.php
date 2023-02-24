<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once __DIR__ . "/../../crud/poste/poste.php";
require_once __DIR__ . "/../../crud/address/address.php";

debugScreen($_POST);
if (isset($_POST['id'])) {
  $id = strip_tags($_POST['id']);
  $nom = strip_tags($_POST['nom']);
  $email_fonc = strip_tags($_POST['email_fonc']);
  $acronyme = strip_tags($_POST['acronyme']);
  $email_secretariat= strip_tags($_POST['email_secretariat']);
  $tel_secretariat = strip_tags($_POST['tel_secretariat']);
  $tel = strip_tags($_POST['tel']);
  $emplacement = strip_tags($_POST['emplacement']);
  $entiteId = strip_tags($_POST['entiteId']);

  $adresseId = getIdAddress($rue, $cp, $ville, $pays);
  if ($adresseId) {
	$adresse = $adresseId["id"];
  } else {
	$adresse = setAddress($rue, $cp, $ville, $pays, "");
  }

  $result = updatePoste($id, $nom, $email_fonc, $entiteId, $acronyme, $adresse, $email_secretariat, $tel_secretariat, $tel, $emplacement);

  if ($result) {
    deleteOrphanAddress();
    echo "success";
  } else {
    echo "error";
  }
}
