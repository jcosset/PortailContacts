<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

debugScreen($_POST);
if (isset($_POST['id'])) {
  $id = strip_tags($_POST['id']);
  //   $photo = strip_tags($_POST['photo']);
  $photo = "#";
  $civil = strip_tags($_POST['civilite']);
  $nom = strip_tags($_POST['nom']);
  $prnom = strip_tags($_POST['prenom']);
  $poste = strip_tags($_POST['poste']);
  $grade = strip_tags($_POST['grade']);
  $email = strip_tags($_POST['email']);
  $tag = strip_tags($_POST['tag']);
  $comment = strip_tags($_POST['commentaire']);
  $emailPro = strip_tags($_POST['emailPro']);
  $telephone = strip_tags($_POST['telephone']);
  $commentaireNiv2 = strip_tags($_POST['commentaireNiv2']);
  $addressID = strip_tags($_POST['addressID']);
  $nom = strip_tags($_POST['nom']);
  $rue = strip_tags($_POST['rue']);
  $complement = strip_tags($_POST['complement']);
  $cp = strip_tags($_POST['cp']);
  $ville = strip_tags($_POST['ville']);
  $pays = strip_tags($_POST['pays']);


  if ($addressID == null || $addressID == 'null') {
    $stmtAddr = "insert into address (Rue, Compl, CP, Ville, Pays ) values (:rue, :complement, :cp, :ville, :pays)";
    $stmtPrepare = $db->prepare($stmtAddr);
    $result =  $stmtPrepare->execute(array(
      ':rue' => $rue, ':complement' => $complement, ':cp' => $cp, ':ville' => $ville,
      ':pays' => $pays
    ));

    $addressID = $db->lastInsertId();
  }

  $stmt = $db->prepare('UPDATE Contact SET Nom=:nom, Prenom=:prenom, Civilite=:civil, Photo=:photo,
     Poste_actuel=:poste, Grade=:grade,
    Email=:email, TAG=:tag, Commentaire=:comment, email_pro=:emailPro, telephone=:telephone,
    commentaire_niv_2=:commentaireNiv2, addressID=:addressID
      where id=:id');


  $result =  $stmt->execute(array(
    ':nom' => $nom, ':prenom' => $prnom, ':civil' => $civil, ':photo' => $photo,
    ':poste' => $poste, ':grade' => $grade, ':email' => $email, ':tag' => $tag, ':comment' => $comment,
    ':emailPro' => $emailPro, ':telephone' => $telephone, ':commentaireNiv2' => $commentaireNiv2,
    ':id' => $id, ':addressID' => $addressID
  ));

  if ($result) {
    echo "success";
  } else {
    echo "error";
  }
}