<?php
require_once __DIR__ . "/../../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);

$poste = strip_tags($_POST['poste']);
$mode = strip_tags($_POST['mode']);
$liste = strip_tags($_POST['listeID']);
$stmt = $db->prepare('INSERT INTO poste_liste_mode_diffusion (posteID,  modeID, listeID)
     VALUES (:poste, :mode, :liste)');

if ($stmt->execute(array(':poste' => $poste, ':mode' => $mode, ':liste' => $liste))) {
  echo "SAVE";
} else {
  debugScreen($db->errorInfo());
}