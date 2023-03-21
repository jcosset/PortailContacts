<?php

//Object
$menus = array(
    'items' => array(),
    'parents' => array(),
    "poste" => array(),
    "contact" => array()
);

function debugScreen($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

$query = "SELECT ID, uper_id, nom FROM Entite ORDER BY nom asc";
$queryGetAllEntites = $db->prepare($query);
$queryGetAllEntites->execute();
//  debugOnScreen($queryGetAllEntites->fetch(PDO::FETCH_ASSOC));

while ($items = $queryGetAllEntites->fetch(PDO::FETCH_ASSOC)) {
    $menus['items'][$items['ID']] = $items;
    $menus['parents'][$items['uper_id']][] = $items['ID'];
}

$query = "SELECT * FROM Poste ORDER BY nom asc";
$queryGetAllPoste = $db->prepare($query);
$queryGetAllPoste->execute();
while ($items = $queryGetAllPoste->fetch(PDO::FETCH_ASSOC)) {
    $menus['poste'][$items['Entite']][] = $items;
}

$query = "SELECT * FROM Contact ORDER BY nom asc";
$queryGetAllContact = $db->prepare($query);
$queryGetAllContact->execute();
while ($items = $queryGetAllContact->fetch(PDO::FETCH_ASSOC)) {
    $menus['contact'][$items['Poste_actuel']][] = $items;
}

function contactArrayToHtml($menu, $posteId)
{

    $htmlPoste = "";

    foreach ($menu[$posteId] as $contact) {
        $isUpdated = $contact["Statut"] == "A mettre à jour" ? "text-warning" : "text-success";
        $id = $contact['id'];
        $htmlPoste .= "<li> <button class='$isUpdated' data-toggle='modal'
         data-target='#largeModal'
          onclick='getContact($id)'> " . $contact['Nom'] . " " . $contact['Prenom'] . ", " . $contact['Grade'] . "</button></li>";
    }
    return $htmlPoste;
}

function posteArrayToHtml($menu, $itemId)
{
    global $menus;
    $htmlPoste = "";
    foreach ($menu[$itemId] as $poste) {
        $id = $poste['id'];
        if (isset($menus['contact'][$id])) {

            $htmlPoste .= "<li>";
            $htmlPoste .= "<div class='listree-submenu-headingxxx text-primary  expanded'
><span data-toggle='modal' data-target='#largeModalPoste' onclick=getPoste($id) style='cursor:pointer;'>
" . $poste['Nom'] . "</span></div>";
            $htmlPoste .= "<ul class='listree-submenu-items' style='display:block;' >";

            $htmlPoste .= contactArrayToHtml($menus['contact'], $id);

            $htmlPoste .= '</ul>';
            $htmlPoste .= "</li>";;
        } else {
            $htmlPoste .= "<li ><span class='text-danger' data-toggle='modal' data-target='#largeModalPoste'
onclick=getPoste($id) style='cursor:pointer;'> " . $poste['Nom'] . "</span></li>";
        }
    }
    return $htmlPoste;
}

function createButtonEdit($itemId, $name, $type)
{
    return "<button class='item' data-toggle='modal' data-target='#displayerModal'  onclick='createPoste(event)' title='Ajouter un poste'>
<i class='zmdi zmdi-plus zmdi-hc-lg text-primary'  data-id=$itemId data-name='$name' data-type='$type'></i>
</button>";
}
function createButtonDetailsEntite($entiteId)
{
    return "<button class='item' data-toggle='modal' data-target='#largeModalEntite'  onclick='getEntite($entiteId)' title='Afficher les informations' >
<i class='zmdi zmdi-receipt text-primary'  ></i>
</button>";
}

function createMenu($parent_id, $menu)
{

    $html = "";

    if (isset($menu['parents'][$parent_id])) {

        foreach ($menu['parents'][$parent_id] as $itemId) {

            if (isset($menu['poste'][$parent_id])) {
                $html .= posteArrayToHtml($menu['poste'], $parent_id);
            }

            if (!isset($menu['parents'][$itemId])) {

                $name = $menu['items'][$itemId]['nom'];

                if (!isset($menu['poste'][$itemId])) {

                    $html .= "<li>" . $name  . "  " . createButtonDetailsEntite($itemId) . "&nbsp;&nbsp;&nbsp;" . createButtonEdit($itemId, $name, 'poste') . "</li>";
                } else if (isset($menu['poste'][$itemId])) {

                    $html .= "<li>";
                    $html .= "<div class='listree-submenu-heading' >" . $name . "  " . createButtonDetailsEntite($itemId) . "&nbsp;&nbsp;&nbsp;" . createButtonEdit($itemId, $name, 'poste') . "</div>";
                    $html .= "<ul class='listree-submenu-items'>";

                    $html .= posteArrayToHtml($menu['poste'], $itemId);

                    $html .= '</ul>';
                    $html .= "</li>";;
                }
            }

            if (isset($menu['parents'][$itemId])) {

                $name = $menu['items'][$itemId]['nom'];

                $html .= "<li>";
                $html .= "<div class='listree-submenu-heading'>" . "$name" . "  " . createButtonDetailsEntite($itemId) . "&nbsp;&nbsp;&nbsp;" . createButtonEdit($itemId, $name, 'poste') . "
</div>";

                $html .= "<ul class='listree-submenu-items'>";

                $html .= createMenu($itemId, $menu);
                $html .= '</ul>';

                $html .= "</li>";
            }
            //Reset parent_id=-1 to display poste one time in loop
            $parent_id = -1;
        }
    }

    return $html;
}