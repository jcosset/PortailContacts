<?php

require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once __DIR__ . "/../../crud/contact/contact.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);
if (isset($_POST['id'])) {
  $id = strip_tags($_POST['id']);
  //   $photo = strip_tags($_POST['photo']);
  $photo = "#";
  $civil = strip_tags($_POST['civilite']);
  $nom = strip_tags($_POST['nom']);
  $prnom = strip_tags($_POST['prenom']);
  $poste = strip_tags($_POST['poste']);
  $grade = strip_tags($_POST['grade']);
  $email = strip_tags($_POST['email']);
  $tag = strip_tags($_POST['tag']);
  $comment = strip_tags($_POST['commentaire']);
  $emailPro = strip_tags($_POST['emailPro']);
  $telephone = strip_tags($_POST['telephone']);
  $commentaireNiv2 = strip_tags($_POST['commentaireNiv2']);
  $addressID = strip_tags($_POST['addressID']);
  $nom = strip_tags($_POST['nom']);
  $rue = strip_tags($_POST['rue']);
  $complement = strip_tags($_POST['complement']);
  $cp = strip_tags($_POST['cp']);
  $ville = strip_tags($_POST['ville']);
  $pays = strip_tags($_POST['pays']);
  $statut = strip_tags($_POST['statut']);


  $adresseId = getIdAddress($rue, $cp, $ville, $pays);

  if ($adresseId) {
    $adresseId = $adresseId["id"];
  } else {
    $adresseId = setAddress($rue, $cp, $ville, $pays, "");
  }


  $result = updateContact($id, $nom, $prnom, $civil, $photo, $poste, $grade, $email, $tag, $comment, $emailPro, $telephone, $commentaireNiv2, $adresseId, $complement,   $statut);

  if ($result) {
    deleteOrphanAddress();
    echo "success";
  } else {
    echo "error";
  }
}
