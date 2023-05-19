<?php

//Object
$menus = array(
    'items' => array(),
    'parents' => array(),
    "poste" => array(),
    "contact" => array()
);

// function debugScreen($var)
// {
//     echo '<pre>';
//     print_r($var);
//     echo '</pre>';
// }

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

function posteArrayToHtml($menu, $itemId, $modes, $posteMethods)
{

    global $menus;
    $htmlPoste = "";

    $optionsHtmlModesDefaultSelected = "";



    foreach ($menu[$itemId] as $poste) {
        $id = $poste['id'];

        $optionsHtmlModesDefaultSelected = '<select name="' . $id . '">
            <option value="0" >Aucun</option>';

        foreach ($modes as $mode) {
            $selected = "";
            foreach ($posteMethods as $posteMethod) {
                $selected = (isset($posteMethod["posteID"]) && $posteMethod["posteID"] == $id) ? "selected" : "";
            }
            $optionsHtmlModesDefaultSelected .= "<option value='" . $mode['id'] . "' " . $selected . ">" . $mode['mode'] . "</option>";
        }
        $optionsHtmlModesDefaultSelected .= "</select>";





        if (isset($menus['contact'][$id])) {

            $htmlPoste .= "<li>";
            $htmlPoste .= "<div class='listree-submenu-headingxxx text-primary  expanded'
                ><span style='cursor:pointer;'>
                " . $poste['Nom'] . "</span> $optionsHtmlModesDefaultSelected </div>";
            $htmlPoste .= "</li>";
        } else {
            $htmlPoste .= "<li ><span class='text-danger'> " . $poste['Nom'] . "</span> $optionsHtmlModesDefaultSelected </li>";
        }
    }
    return $htmlPoste;
}


function createMenu($parent_id, $menu, $modes, $posteMethods)
{

    $html = "";

    if (isset($menu['parents'][$parent_id])) {

        foreach ($menu['parents'][$parent_id] as $itemId) {

            if (isset($menu['poste'][$parent_id])) {
                $html .= posteArrayToHtml($menu['poste'], $parent_id, $modes, $posteMethods);
            }

            if (!isset($menu['parents'][$itemId])) {

                $name = $menu['items'][$itemId]['nom'];

                if (!isset($menu['poste'][$itemId])) {

                    $html .= "<li>" . $name  . "</li>";
                } else if (isset($menu['poste'][$itemId])) {

                    $html .= "<li>";
                    $html .= "<div class='listree-submenu-heading' >" . $name . "</div>";
                    $html .= "<ul class='listree-submenu-items'>";

                    $html .= posteArrayToHtml($menu['poste'], $itemId, $modes, $posteMethods);

                    $html .= '</ul>';
                    $html .= "</li>";
                }
            }

            if (isset($menu['parents'][$itemId])) {

                $name = $menu['items'][$itemId]['nom'];

                $html .= "<li>";
                $html .= "<div class='listree-submenu-heading'>" . "$name" . "
</div>";

                $html .= "<ul class='listree-submenu-items'>";

                $html .= createMenu($itemId, $menu, $modes, $posteMethods);
                $html .= '</ul>';

                $html .= "</li>";
            }
            //Reset parent_id=-1 to display poste one time in loop
            $parent_id = -1;
        }
    }


    return $html;
}
