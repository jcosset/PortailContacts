<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once __DIR__ . "/../../crud/upload/upload.php";


debugScreen($_POST);
$civil = strip_tags($_POST['civilite']);
$nom = strip_tags($_POST['nom']);
$prenom = strip_tags($_POST['prenom']);
$grade = strip_tags($_POST['grade']);
$email = strip_tags($_POST['email']);
$poste = strip_tags($_POST['poste']);
$tag = strip_tags($_POST['tag']);
$comment = strip_tags($_POST['commentaire']);
$emailPro = strip_tags($_POST['emailPro']);
$telephone = strip_tags($_POST['telephone']);
$commentaireNiv2 = strip_tags($_POST['commentaireNiv2']);
$adresse = strip_tags($_POST['adresse']);
$complement = strip_tags($_POST['complement']);
$CP = strip_tags($_POST['CP']);
$ville = strip_tags($_POST['ville']);
$pays = strip_tags($_POST['pays']);

if (isset($_FILES['file'])) {
  $hashNameFile = hash('md5', $nom.$prenom);
  $resUpload = uploadFile($_FILES['file'], $hashNameFile);
  if(!empty(resUpload)){
$addressinBDD = getIdAddress($adresse, $CP, $ville, $pays);
$addressID = "";

if ($addressinBDD) {
  $addressID = $addressinBDD["id"];
} else {
  $addressID = setAddress($adresse, $CP, $ville, $pays, "");
}

$stmt = $db->prepare('INSERT INTO Contact (Civilite, Nom, Prenom, Grade, Email, Poste_actuel, Tag, Commentaire, Photo, Date_MAJ, Statut,
    email_pro, telephone, commentaire_niv_2, addressID, compl
    )
     VALUES (:civil, :nom, :prenom,:grade, :email, :poste, :tag, :commentaire, :photo, curdate(),
      "En attente",:emailPro, :telephone, :commentaireNiv2, :addressID, :compl)');

$result =  $stmt->execute(array(
  ':civil' => $civil, ':nom' => $nom, ':prenom' => $prenom, ':grade' => $grade, ':email' => $email,
  ':poste' => $poste, ':tag' => $tag, ':commentaire' => $comment, ':photo' => $resUpload, ':emailPro' => $emailPro, ':telephone' => $telephone,
  ':commentaireNiv2' => $commentaireNiv2, ':addressID' => $addressID, ':compl' => $complement
));

if ($result) {
  echo "success";
} else {
  echo "Error";
  debugScreen($db->errorInfo());
}
  	
  }
} else {
$addressinBDD = getIdAddress($adresse, $CP, $ville, $pays);
$addressID = "";

if ($addressinBDD) {
  $addressID = $addressinBDD["id"];
} else {
  $addressID = setAddress($adresse, $CP, $ville, $pays, "");
}

$stmt = $db->prepare('INSERT INTO Contact (Civilite, Nom, Prenom, Grade, Email, Poste_actuel, Tag, Commentaire, Photo, Date_MAJ, Statut,
    email_pro, telephone, commentaire_niv_2, addressID, compl
    )
     VALUES (:civil, :nom, :prenom,:grade, :email, :poste, :tag, :commentaire, :photo, curdate(),
      "En attente",:emailPro, :telephone, :commentaireNiv2, :addressID, :compl)');

$result =  $stmt->execute(array(
  ':civil' => $civil, ':nom' => $nom, ':prenom' => $prenom, ':grade' => $grade, ':email' => $email,
  ':poste' => $poste, ':tag' => $tag, ':commentaire' => $comment, ':photo' => "#photo", ':emailPro' => $emailPro, ':telephone' => $telephone,
  ':commentaireNiv2' => $commentaireNiv2, ':addressID' => $addressID, ':compl' => $complement
));

if ($result) {
  echo "success";
} else {
  echo "Error";
  debugScreen($db->errorInfo());
}
}



