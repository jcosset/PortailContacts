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
  $nom_secretariat= strip_tags($_POST['nom_secretariat']);
  $prenom_secretariat= strip_tags($_POST['prenom_secretariat']);
  $email_secretariat= strip_tags($_POST['email_secretariat']);
  $tel_secretariat = strip_tags($_POST['tel_secretariat']);
  $tel = strip_tags($_POST['tel']);
  $emplacement = strip_tags($_POST['emplacement']);
  $entiteId = strip_tags($_POST['entiteId']);

  // The is adress in db but it is never show / used anywhere else for this table.
  // Idk why there is this portion of code (i guess it was copy / paste from entité)
  // $adresseId = getIdAddress($rue, $cp, $ville, $pays);
  // if ($adresseId) {
	// $adresse = $adresseId["id"];
  // } else {
	// $adresse = setAddress($rue, $cp, $ville, $pays, "");
  // }

  $result = updatePoste($id, $nom, $email_fonc, $entiteId, $acronyme, $nom_secretariat, $prenom_secretariat, $email_secretariat, $tel_secretariat, $tel, $emplacement);

  if ($result) {
    deleteOrphanAddress();
    echo "success";
  } else {
    echo "error";
  }
}