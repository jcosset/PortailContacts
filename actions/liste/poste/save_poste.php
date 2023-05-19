<?php
require_once __DIR__ . "/../../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);
if (isset($_REQUEST['revert'])) {
  $liste = strip_tags($_POST['liste']);
} else {
  $poste = strip_tags($_POST['poste']);
}
$values = "";

$parameters = array_filter($_POST, function ($mode) {
  return $mode != 0;
});
unset($parameters["poste"]);
unset($parameters["liste"]);



foreach ($parameters as $key => $mode) {
  if (isset($_REQUEST['revert'])) {
    $values = $values == "" ? "($key, $liste, $mode)" : $values . "," . "($key, $liste, $mode)";
  } else {
    $values = $values == "" ? "($poste, $key, $mode)" : $values . "," . "($poste, $key, $mode)";
  }
}

var_dump($values);


if (isset($_REQUEST['revert'])) {
  $deleteRows = $db->prepare("DELETE from poste_liste_mode_diffusion where listeID = $liste");
} else {
  $deleteRows = $db->prepare("DELETE from poste_liste_mode_diffusion where posteID = $poste");
}

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
