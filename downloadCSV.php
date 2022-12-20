<?php

include 'inc/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function debugScreen($var)
{
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

if (isset($_POST["listeID"])) {
  $listeID = $_POST["listeID"];
  $stmt = "SELECT distinct pos.Nom as 'Nom du poste', ent.Nom as 'Nom du partenaire', pos.Rue as 'Poste Rue',
pos.Compl as 'Poste Complement' , pos.CP as 'Poste CP', pos.Ville as 'Poste Ville', pos.Pays as 'Poste Pays',
Civilite, cont.Nom as 'Nom', Prenom, Grade, Email as 'Email personnel',
Email_fonctionnel as 'Email fonctionnel', mode as 'Mode de diffusion', pos.id, lis.id as ListeID, plmd.id as 'plmd'

FROM poste_liste_mode_diffusion as plmd join mode_diffusion as md on (plmd.modeID=md.id) join 
Liste as lis on (plmd.listeID = lis.id) join Poste as pos on (plmd.posteID =pos.id)  
join Entite as ent on (pos.Entite =ent.id) join 
Contact as cont on (cont.Poste_actuel=pos.id)
   and lis.id = :listeID group by plmd.id

 ";
  $stmtPrepare = $db->prepare($stmt);
  $stmtPrepare->execute(array(":listeID" => $listeID));


  $filename = "listeDiffusion.csv";
  $fp = fopen($filename, 'w');
  fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
  $seperator = ";";
  //header
  $header = array(
    "Nom du poste", "Nom du partenaire", "Poste rue", "Poste complément", "Poste CP", "Poste ville",
    "Poste pays", "Civilite", "Nom", "Prenom", "Grade", "Email personnel", "Email fonctionnel", "Mode de diffusion"
  );
  fputcsv($fp, $header, $seperator);

  //write rows
  while ($row = $stmtPrepare->fetch(PDO::FETCH_ASSOC)) {
    // debugScreen($row);
    fputcsv($fp, $row,  $seperator);
  }
  fseek($fp, 0);
  // download
  header('Content-Encoding: utf-8');
  header("Content-Type: text/csv;charset=utf-8");
  header('Content-Disposition: attachment; filename="' . $filename);


  // header("Content-Transfer-Encoding: UTF-8");
  // header('Content-Transfer-Encoding: binary');
  // header('Expires: 0');
  // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  // header('Pragma: public');



  readfile($filename);
  // fpassthru($fp);

  // deleting file
  unlink($filename);

  exit();
}

 
//header('Content-Disposition: attachment; filename=users.csv');
