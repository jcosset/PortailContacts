<?php

require_once __DIR__."/../../config.php";
require_once __DIR__."/../../crud/address/address.php";
require_once __DIR__."/../../crud/entite/entite.php";
require_once SITE_ROOT."/inc/helpers/debug.php";

if (isset($_POST['nom']) & isset($_POST['uper_id'])) {
  $nom = strip_tags($_POST['nom']);
  $uper_id = strip_tags($_POST['uper_id']);
  $acronyme = strip_tags($_POST['acronyme']);
  $telephone = strip_tags($_POST['telephone']);
  $adresse_geo = strip_tags($_POST['adresseGeo']);
  $compl_geo = strip_tags($_POST['complémentGeo']);
  $CP_geo = strip_tags($_POST['CPGeo']);
  $ville_geo = strip_tags($_POST['villeGeo']);
  $pays_geo = strip_tags($_POST['paysGeo']);
  $adresse_pos = strip_tags($_POST['adressePos']);
  $compl_pos = strip_tags($_POST['complémentPos']);
  $CP_pos = strip_tags($_POST['CPPos']);
  $ville_pos = strip_tags($_POST['villePos']);
  $pays_pos = strip_tags($_POST['paysPos']);
  $site = strip_tags($_POST['site']);
  $logo = strip_tags($_POST['logo']);

$addressGeoInBDD = getIdAddress($adresse_geo, $CP_geo, $ville_geo, $pays_geo);
$addressGeoID = "";

if ($addressGeoInBDD) {
  $addressGeoID = $addressGeoInBDD["id"];
} else {
  $addressGeoID = setAddress($adresse_geo, $compl_geo, $CP_geo, $ville_geo, $pays_geo, "");
}

$addressPosInBDD = getIdAddress($adresse_pos, $CP_pos, $ville_pos, $pays_pos);
$addressPosID = "";

if ($addressPosInBDD) {
  $addressPosID = $addressPosInBDD["id"];
} else {
  $addressPosID = setAddress($adresse_pos, $compl_pos, $CP_pos, $ville_pos, $pays_pos, "");
}

$returnSetEntity = setEntity($nom, $uper_id, $acronyme, $telephone, $addressGeoID, $addressPosID, $site, $logo);

if($returnSetEntity){
    echo "success";
  }else{
    echo "error";
  }
}

debugScreen($_POST);
