<?php

require_once __DIR__."/../../config.php";
require_once SITE_ROOT."/inc/helpers/debug.php";

if (isset($_POST['nom']) & isset($_POST['uper_id']) & isset($_POST['id'])) {
  $id = strip_tags($_POST['id']);
  $nom = strip_tags($_POST['nom']);
  $uper_id = strip_tags($_POST['uper_id']);
  debugScreen($id);

  $stmt = $db->prepare('UPDATE Entite SET Nom=:nom, Uper_id=:uper_id where id=:id');
  if($stmt->execute(array(':nom' => $nom, ':uper_id' => $uper_id, ':id' => $id))){
    echo "success";
  }else{
    echo "error";
  }
}

debugScreen($_POST);
