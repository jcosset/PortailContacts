<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";


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
  $tmpName = $_FILES['file']['tmp_name'];
  $name = $_FILES['file']['name'];
  $size = $_FILES['file']['size'];
  $error = $_FILES['file']['error'];
}

$stmt = $db->prepare('SELECT id from address where Rue=:adresse and CP=:CP and Ville=:ville and Pays=:pays;');
$result =  $stmt->execute(array(  ':adresse' => $adresse, ':CP' => $CP, ':ville' => $ville, ':pays' => $pays));

if ($result) {
  $addressID = $stmt->fetchColumn();
} else {
  $stmt = $db->prepare('INSERT INTO address (Rue, CP, Ville, Pays)
  VALUES (:adresse, :CP, :ville, :pays)');
  $result =  $stmt->execute(array(  ':adresse' => $adresse, ':CP' => $CP, ':ville' => $ville, ':pays' => $pays));
  $addressID = $db->lastInsertId();
}

$stmt = $db->prepare('INSERT INTO Contact (Civilite, Nom, Prenom, Grade, Email, Poste_actuel, Tag, Commentaire, Photo, Date_MAJ, Statut,
    email_pro, telephone, commentaire_niv_2
    )
     VALUES (:civil, :nom, :prenom,:grade, :email, :poste, :tag, :commentaire, :photo, curdate(),
      "En attente",:emailPro, :telephone, :commentaireNiv2)');

$result =  $stmt->execute(array(
  ':civil' => $civil, ':nom' => $nom, ':prenom' => $prenom, ':grade' => $grade, ':email' => $email,
  ':poste' => $poste, ':tag' => $tag, ':commentaire' => $comment, ':photo' => "#photo", ':emailPro' => $emailPro, ':telephone' => $telephone,
  ':commentaireNiv2' => $commentaireNiv2
));

if ($result) {
  echo "success";
} else {
  echo "Error";
  debugScreen($db->errorInfo());
}

