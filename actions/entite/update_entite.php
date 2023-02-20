<?php

require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once __DIR__ . "/../../crud/entite/entite.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (isset($_POST['nom']) & isset($_POST['uper_id']) & isset($_POST['id'])) {
  $id = strip_tags($_POST['id']);
  $nom = strip_tags($_POST['nom']);
  $uper_id = strip_tags($_POST['uper_id']);
  $acronyme = strip_tags($_POST['acronyme']);
  $email = strip_tags($_POST['email']);
  $telephone = strip_tags($_POST['telephone']);
  $site = strip_tags($_POST['site']);
  $logo = strip_tags($_POST['logo']);
  $adresse_geo = strip_tags($_POST['adresseGeo']);
  $compl_geo = strip_tags($_POST['complementGeo']);
  $cp_geo = strip_tags($_POST['CPGeo']);
  $ville_geo = strip_tags($_POST['villeGeo']);
  $pays_geo = strip_tags($_POST['paysGeo']);
  $adresse_pos = strip_tags($_POST['adressePos']);
  $compl_pos = strip_tags($_POST['complementPos']);
  $cp_pos = strip_tags($_POST['CPPos']);
  $ville_pos = strip_tags($_POST['villePos']);
  $pays_pos = strip_tags($_POST['paysPos']);


  $adresseIdGeo = getIdAddress($adresse_geo, $cp_geo, $ville_geo, $pays_geo);
  $adresseIdPos = getIdAddress($adresse_pos, $cp_pos, $ville_pos, $pays_pos);

  if ($adresseIdGeo  && $adresse_geo !== "0") {
    $adresse_geo = $adresseIdGeo["id"];
  } else {

    $adresse_geo = setAddress($adresse_geo, $cp_geo, $ville_geo, $pays_geo, "");
  }

  if ($adresseIdPos &&  $adresse_pos !== "0") {
    $adresse_pos = $adresseIdPos["id"];
  } else {
    $adresse_pos = setAddress($adresse_pos, $cp_pos, $ville_pos, $pays_pos, "");
  }

  $result = updateEntite($id, $nom, $uper_id, $acronyme, $email, $telephone, $adresse_geo, $adresse_pos, $site, $logo, $compl_geo, $compl_pos);

  if ($result) {
    deleteOrphanAddress();
    echo "success";
  } else {
    echo "error";
  }
}

debugScreen($_POST);
