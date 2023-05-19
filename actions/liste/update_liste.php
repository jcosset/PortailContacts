<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);
if (isset($_POST['listeID'])) {
  $listeID = strip_tags($_POST['listeID']);
  $listeNom = strip_tags($_POST['Nom']);
  $modes = $_POST['modes'];
  $firstLoop = true;


  $updateListe = $db->prepare("UPDATE liste SET nom = '$listeNom' where id = $listeID");
  $deleteListeModeDif = $db->prepare("DELETE FROM liste_mode_diffusion where listeID = $listeID");

  $query = "INSERT INTO liste_mode_diffusion (listeID, modeID) values ";

  foreach ($modes as $mode) {
    $query .= $firstLoop ? "($listeID, $mode)" : ",($listeID, $mode)";
    $firstLoop = false;
  }
  $insertListeModeDif = $db->prepare($query);

  debugScreen($updateListe);
  $updateListe->execute();
  debugScreen($deleteListeModeDif);
  $deleteListeModeDif->execute();
  debugScreen($insertListeModeDif);
  $insertListeModeDif->execute();
}
