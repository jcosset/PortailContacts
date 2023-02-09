<?php
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/poste/poste.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);

$nom = strip_tags($_POST['nom']);
$rue = strip_tags($_POST['rue']);
$complement = strip_tags($_POST['complement']);
$cp = strip_tags($_POST['cp']);
$ville = strip_tags($_POST['ville']);
$pays = strip_tags($_POST['pays']);
$entiteId = strip_tags($_POST['entiteId']);
$email_fonc = strip_tags($_POST['email_fonc']);
$acronyme = strip_tags($_POST['acronyme']);
$email_secretariat= strip_tags($_POST['email_secretariat']);
$tel_secretariat = strip_tags($_POST['tel_secretariat']);
$tel = strip_tags($_POST['tel']);

$adresseId = getIdAddress($rue, $cp, $ville, $pays);
if ($adresseId) {
	$adresse = $adresseId["id"];
} else {
	$adresse = setAddress($rue, $cp, $ville, $pays, "");
}
$resultSetPoste = setPoste($nom, $email_fonc, $entiteId, $acronyme, $adresse, $email_secretariat, $tel_secretariat, $tel, $complement);
if ($resultSetPoste != 0) {
    echo "SAVE";
} else {
    echo "error";
}
