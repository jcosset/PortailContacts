<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once('Traits/Index/index_arbo.php');

function getListAndModeById($id, $db)
{
    $getPoste = $db->prepare('Select md.id as id, md.mode as mode from Liste as lis
         join liste_mode_diffusion as lmd on (lis.id=lmd.listeID)
         join mode_diffusion as md on (md.id = lmd.modeID) and lis.id=:id
        ');
    $result = $getPoste->execute(array(':id' => $id));

    return $result ? $getPoste->fetchAll(PDO::FETCH_ASSOC) : "erreur";
}

function getPostMethodsFromPosteId($id, $db)
{
    $sqlFetch = $db->prepare("Select * from poste_liste_mode_diffusion where posteID = :posteid");
    return $sqlFetch->execute(array(':posteid' => $id)) ? $sqlFetch->fetchAll(PDO::FETCH_ASSOC) : "erreur";
}

function getListMethodsFromPosteId($id, $db)
{
    $sqlFetch = $db->prepare("Select * from liste_mode_diffusion where listeID = :listeid");
    return $sqlFetch->execute(array(':listeid' => $id)) ? $sqlFetch->fetchAll(PDO::FETCH_ASSOC) : "erreur";
}


function getPostMethodsFromListId($id, $db)
{
    $sqlFetch = $db->prepare("Select * from poste_liste_mode_diffusion where listeID = :id");
    return $sqlFetch->execute(array(':id' => $id)) ? $sqlFetch->fetchAll(PDO::FETCH_ASSOC) : "erreur";
}

if (isset($_REQUEST['id'])) {
    $id = strip_tags($_REQUEST['id']);
    $getPoste = $db->prepare('Select GROUP_CONCAT(md.id  SEPARATOR ",") as ids, GROUP_CONCAT(md.mode  SEPARATOR ",")
         as modes  from Liste as lis join liste_mode_diffusion as lmd on (lis.id=lmd.listeID)
         join mode_diffusion as md on (md.id = lmd.modeID) and lis.id=:id
        ');
    if ($result = $getPoste->execute(array(':id' => $id))) {
        $row = $getPoste->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        debugScreen($db->errorInfo());
        echo json_encode("erreur");
    }
}


if (isset($_REQUEST['id_obj'])) {
    $id = strip_tags($_REQUEST['id_obj']);
    echo json_encode(getListAndModeById($id, $db));
}

if (isset($_REQUEST['selectById'])) {
    $id = strip_tags($_REQUEST['selectById']);
    $sqlFetch = $db->prepare("SELECT * FROM liste where id = $id");
    echo json_encode($sqlFetch->execute() ? $sqlFetch->fetch(PDO::FETCH_ASSOC) : "erreur");
}

if (isset($_REQUEST['all'])) {

    $sqlFetch = $db->prepare('Select nom, lis.id as id, GROUP_CONCAT(md.id  SEPARATOR ",") as ids,
     GROUP_CONCAT(md.mode  SEPARATOR ",") as modes  from Liste as lis
     join liste_mode_diffusion as lmd on (lis.id=lmd.listeID)
     join mode_diffusion as md on (md.id = lmd.modeID) group by lis.id');

    if ($result = $sqlFetch->execute()) {
        $rows = $sqlFetch->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } else {
        echo json_encode("erreur");
    }
}

if (isset($_REQUEST['allLists'])) {

    $sqlFetch = $db->prepare('Select id, nom from Liste');

    if ($result = $sqlFetch->execute()) {
        $rows = $sqlFetch->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } else {
        echo json_encode("erreur");
    }
}

function getAllMethods($db)
{
    $sqlFetch = $db->prepare('Select id, mode from mode_diffusion');
    $result = $sqlFetch->execute();

    return $result ? $sqlFetch->fetchAll(PDO::FETCH_ASSOC) : "erreur";
}

if (isset($_REQUEST['allMethods'])) {
    echo json_encode(getAllMethods($db));
}

if (isset($_REQUEST['getPostMethodsFromId'])) {
    $id = strip_tags($_REQUEST['getPostMethodsFromId']);
    echo json_encode(getPostMethodsFromPosteId($id, $db));
}

if (isset($_REQUEST['getListMethodsFromId'])) {
    $id = strip_tags($_REQUEST['getListMethodsFromId']);
    echo json_encode(getListMethodsFromPosteId($id, $db));
}

if (isset($_REQUEST['listree'])) {
    $id = strip_tags($_REQUEST['listree']);
    $list = getListAndModeById($id, $db);
    $postMethod = getPostMethodsFromListId($id, $db);
    echo json_encode(createMenu(0, $menus, $list, $postMethod));
}
