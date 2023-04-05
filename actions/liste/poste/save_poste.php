<?php
require_once __DIR__ . "/../../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);

$poste = strip_tags($_POST['poste']);
$values = "";

$parameters = array_filter($_POST, function ($mode) {
  return $mode != 0;
});
unset($parameters["poste"]);

foreach ($parameters as $liste => $mode) {
  $values = $values == "" ? "($poste, $liste, $mode)" : $values . "," . "($poste, $liste, $mode)";
}
$deleteRows = $db->prepare("DELETE from poste_liste_mode_diffusion where posteID = $poste");
$stmt = $db->prepare("INSERT INTO poste_liste_mode_diffusion (posteID, listeID, modeID) VALUES $values");
debugScreen("INSERT INTO poste_liste_mode_diffusion (posteID, listeID, modeID) VALUES $values");

if ($deleteRows->execute()) {
  if ($stmt->execute()) {
    echo "SAVE";
  } else {
    debugScreen($db->errorInfo());
  }
} else {
  debugScreen($db->errorInfo());
}