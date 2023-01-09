<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);
if (isset($_POST['listeID'])) {
  $id = strip_tags($_POST['listeID']);
  $postes = $_POST['postes'];

  if (count($postes) > 0) {
    $postesID = implode(",", $postes);

    $stmt = $db->prepare("Delete FROM poste_liste_mode_diffusion where posteID in (:postesID) and
    listeID=:listeID
    ");
    debugScreen($stmt);
    $result =  $stmt->execute(array(
      ':postesID' => $postesID,
      ':listeID' => $id
    ));

    if ($result) {
      echo "success";
    } else {
      echo "error";
    }
  }
}