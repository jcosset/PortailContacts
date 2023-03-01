<?php
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/poste/poste.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);

$nom = strip_tags($_POST['nom']);
$entiteId = strip_tags($_POST['entiteId']);
$email_fonc = strip_tags($_POST['email_fonc']);
$acronyme = strip_tags($_POST['acronyme']);
$email_secretariat = strip_tags($_POST['email_secretariat']);
$tel_secretariat = strip_tags($_POST['tel_secretariat']);
$tel = strip_tags($_POST['tel']);
$emplacement = strip_tags($_POST['emplacement']);


$resultSetPoste = setPoste($nom, $email_fonc, $entiteId, $acronyme, $email_secretariat, $tel_secretariat, $tel, $emplacement);
if ($resultSetPoste != 0) {
    echo "SAVE";
} else {
    echo "error";
}