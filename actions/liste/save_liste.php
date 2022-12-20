<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";


debugScreen($_POST);
if (true) {
  $nom = strip_tags($_POST['nom']);
  $modes = $_POST['modes'];
  


  $stmt = $db->prepare('INSERT INTO Liste (Nom) VALUES (:nom)');

  if ($stmt->execute(array(':nom' => $nom))) {
   
    $listeID = $db->lastInsertId();
    $stmt2 = $db->prepare('INSERT INTO liste_mode_diffusion (listeId, modeId) VALUES (:listeId, :modeId)');
    foreach ($modes as $mode) {
      $stmt2->bindValue(':listeId', $listeID);
      $stmt2->bindValue(':modeId',  $mode);
      $stmt2->execute();
    }
    echo "SAVE";
  } else {
    debugScreen($db->errorInfo());
  }
}
