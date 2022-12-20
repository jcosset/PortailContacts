<?php

require_once __DIR__."/../../config.php";
require_once SITE_ROOT."/inc/helpers/debug.php";

if (isset($_POST['nom']) & isset($_POST['uper_id'])) {
  $nom = strip_tags($_POST['nom']);
  $uper_id = strip_tags($_POST['uper_id']);

  $stmt = $db->prepare('INSERT INTO Entite (Nom, Uper_id) VALUES (:nom, :uper_id)');
  if($stmt->execute(array(':nom' => $nom, ':uper_id' => $uper_id))){
    echo "success";
  }else{
    echo "error";
  }
}

debugScreen($_POST);
