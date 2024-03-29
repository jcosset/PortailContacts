<?php

include 'inc/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function debugScreen($var)
{
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

if (isset($_POST["listeID"])) {
  $listeID = $_POST["listeID"];
  $stmt = "SELECT distinct pos.Nom as 'Nom du poste' , pos.acronyme, ent.Nom 'Entite nom',
  ent.acronyme as 'Entite acronyme', addrPostal.Rue as 'addrPostal Rue',
  ent.compl_postale as 'addrPostal Complement', addrPostal.Ville as 'addrPostal Ville',
  addrPostal.CP as 'addrPostal CP', addrPostal.Pays as 'addrPostal Pays',
  ent.cedex as 'addrPostal cedex',
  addrGeo.Rue as 'addrGeo Rue',  ent.compl_geo as 'addrGeo Complement',
 addrGeo.Ville as 'addrGeo Ville', addrGeo.CP as 'addrGeo CP',  addrGeo.Pays as 'addrGeo Pays',
Civilite, cont.Nom as 'Nom', Prenom, Grade, cont.Email as 'Email personnel',
pos.Email_fonctionnel as 'Email fonctionnel',cont.telephone as 'telephone', mode as 'Mode de diffusion', pos.id, lis.id as ListeID, plmd.id as 'plmd'

FROM poste_liste_mode_diffusion as plmd join mode_diffusion as md on (plmd.modeID=md.id) join
Liste as lis on (plmd.listeID = lis.id) join Poste as pos on (plmd.posteID =pos.id)
join Entite as ent on (pos.Entite =ent.id) join
Contact as cont on (cont.Poste_actuel=pos.id) left join `address` as addrGeo on (ent.adresse_geo =addrGeo.id)
 left join `address` as addrPostal on (ent.adresse_postale =addrPostal.id)
   and lis.id = :listeID where lis.id = :listeID group by plmd.id

 ";
  $stmtPrepare = $db->prepare($stmt);
  $stmtPrepare->execute(array(":listeID" => $listeID));

  $filename = "listeDiffusion.csv";
  $fp = fopen($filename, 'w');
  fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
  $seperator = ";";
  //header
  $header = array(
    "Nom du poste", "Acronyme du poste", "Nom du partenaire",
    "Acronyme du partenaire", "Parternaire postale rue",  "Parternaire postale complement",
    "Parternaire postale cp", "Parternaire postale ville",
    "Parternaire postale pays", "Parternaire postale cedex",
    "Parternaire geo rue",  "Parternaire geo complement", "Parternaire geo cp", "Parternaire geo ville",
    "Parternaire geo pays",
    "Civilite", "Nom", "Prenom", "Grade",
    "Email personnel", "Email fonctionnel", "téléphone portale", "Mode de diffusion"
  );
  fputcsv($fp, $header, $seperator);

  //write rows
  while ($row = $stmtPrepare->fetch(PDO::FETCH_ASSOC)) {
    // var_dump($row);
    // debugScreen($row);
    fputcsv($fp, $row,  $seperator);
  }
  fseek($fp, 0);
  // download
  header('Content-Encoding: utf-8');
  header("Content-Type: text/csv;charset=utf-8");
  header('Content-Disposition: attachment; filename="' . $filename);

  readfile($filename);

  // deleting file
  unlink($filename);

  exit();
}

// header('Content-Disposition: attachment; filename=users.csv');