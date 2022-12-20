<?php include "inc/header.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="listree">
                        <?php
                        require('inc/db.php');
                        function debugScreen($var)
                        {
                            echo '<pre>';
                            print_r($var);
                            echo '</pre>';
                        }
                        // $query = "SELECT ID, uper_id, nom FROM Entite ORDER BY nom asc";
                        // $queryGetAllEntites = $db->prepare($query);
                        // $queryGetAllEntites->execute();
                        // //  debugOnScreen($queryGetAllEntites->fetch(PDO::FETCH_ASSOC));
                        // while ($items = $queryGetAllEntites->fetch(PDO::FETCH_ASSOC)) {
                        //   $arborescence['items'][$items['ID']] = $items;
                        //   $arborescence['parents'][$items['uper_id']][] = $items['ID'];
                        // }
                        // $query = "SELECT * FROM Poste ORDER BY nom asc";
                        // $queryGetAllPoste = $db->prepare($query);
                        // $queryGetAllPoste->execute();
                        // while ($items = $queryGetAllPoste->fetch(PDO::FETCH_ASSOC)) {
                        //   $arborescence['poste'][$items['Entite']][] = $items;
                        // }
                        // $query = "SELECT * FROM Contact ORDER BY nom asc";
                        // $queryGetAllContact = $db->prepare($query);
                        // $queryGetAllContact->execute();
                        // while ($items = $queryGetAllContact->fetch(PDO::FETCH_ASSOC)) {
                        //   $arborescence['contact'][$items['Poste_actuel']][] = $items;
                        // }
                        function createButtonEdit($itemId, $name, $type)
                        {
                            return "<button class='item' data-toggle='modal' data-target='#displayerModal'  onclick='createPoste(event)' title='Edit'>
              <i class='zmdi zmdi-plus zmdi-hc-lg text-primary'  data-id=$itemId data-name='$name' data-type='$type'></i>
                </button>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="listree">
                        <?php
                        require('inc/db.php');
                        //Object
                        $arborescence = array(
                            'items' => array(),
                            'parents' => array(),
                            "poste" => array(),
                            "contact" => array(),
                            "postes" => array(),
                        );
                        $query = "SELECT id,  nom FROM Liste ORDER BY nom asc";
                        $queryGetAllListes = $db->prepare($query);
                        $queryGetAllListes->execute();
                        //  debugOnScreen($queryGetAllEntites->fetch(PDO::FETCH_ASSOC));
                        while ($listes = $queryGetAllListes->fetch(PDO::FETCH_ASSOC)) {
                            $arborescence['listes'][$listes['id']] = $listes;
                        }
                        $query = 'SELECT pos.Nom as nom, md.mode, plmd.listeID as listeID
            FROM poste_liste_mode_diffusion as plmd  join Poste as pos on plmd.posteID = pos.id  join
            mode_diffusion as md on (md.id = plmd.modeID)';
                        $queryGetAllPostes = $db->prepare($query);
                        $queryGetAllPostes->execute();
                        while ($postes = $queryGetAllPostes->fetch(PDO::FETCH_ASSOC)) {
                            $arborescence['postes'][$postes['listeID']][] = $postes;
                        }
                        // $query = "SELECT * FROM Contact ORDER BY nom asc";
                        // $queryGetAllContact = $db->prepare($query);
                        // $queryGetAllContact->execute();
                        // while ($items = $queryGetAllContact->fetch(PDO::FETCH_ASSOC)) {
                        //   $arborescence['contact'][$items['Poste_actuel']][] = $items;
                        // }
                        // function _contactArrayToHtml($menu, $posteId)
                        // {
                        //   $htmlPoste = "";
                        //   foreach ($menu[$posteId] as $contact) {
                        //     $isUpdated = "text-success";
                        //     $id = $contact['id'];
                        //     $htmlPoste .= "<li> <button class='$isUpdated' data-toggle='modal' data-target='#largeModal' onclick=getContact($id)> " . $contact['Nom'] . "</button></li>";
                        //   }
                        //   return $htmlPoste;
                        // }
                        // function _posteArrayToHtml($menu, $itemId)
                        // {
                        //   global $arborescence;
                        //   $htmlPoste = "";
                        //   foreach ($menu[$itemId] as $poste) {
                        //     $id = $poste['id'];
                        //     if (isset($arborescence['contact'][$id])) {
                        //       $htmlPoste .= "<li>";
                        //       $htmlPoste .= "<div class='listree-submenu-headingxxx text-primary  expanded'
                        //       ><span data-toggle='modal' data-target='#largeModal' onclick=getPoste($id) style='cursor:pointer;'>
                        //       " . $poste['Nom'] . "</span></div>";
                        //       $htmlPoste .= "<ul class='listree-submenu-items' style='display:block;' >";
                        //       $htmlPoste .=  contactArrayToHtml($arborescence['contact'],  $id);
                        //       $htmlPoste .= '</ul>';
                        //       $htmlPoste .= "</li>";;
                        //     } else {
                        //       $htmlPoste .= "<li ><span class='text-danger' data-toggle='modal' data-target='#largeModal'
                        //        onclick=getPoste($id) style='cursor:pointer;'> " . $poste['Nom'] . "</span></li>";
                        //     }
                        //   }
                        //   return $htmlPoste;
                        // }
                        function _createButtonEdit($itemId, $name, $type)
                        {
                            return "<button class='item' data-toggle='modal' data-target='#displayerModal'  onclick='createPoste(event)' title='Edit'>
              <i class='zmdi zmdi-plus zmdi-hc-lg text-primary'  data-id=$itemId data-name='$name' data-type='$type'></i>
                </button>";
                        }
                        function createButtonDownload($listeID)
                        {
                            return '<form action="downloadCSV.php" method="POST" style="">
                          <input name="listeID"    hidden value="' . $listeID . '">
                          <button class="item" style="" id="downloadForm" type="submit" data-toggle="tooltip" data-placement="top" title="download csv">
                            <i class="zmdi zmdi-download"  style=""></i>
                          </button>
                        </form>';
                        }
                        function createArborescenceListeDiff()
                        {
                            global $arborescence;
                            $html = "";
                            foreach ($arborescence["listes"] as $liste) {
                                $name = $liste['nom'];
                                $listeID = $liste['id'];
                                $html .= "<li>";
                                $html .= "<div class='listree-submenu-heading'>" . $name  . "</div>";
                                $html .= "<ul class='listree-submenu-items'>" . createButtonDownload($listeID);
                                if (isset($arborescence['postes'][$listeID])) {;
                                    foreach ($arborescence['postes'][$listeID] as $poste) {
                                        $posteName = $poste['nom'];
                                        $html .= "<li > <span class='item' data-toggle='modal' data-target='#largeModal'
                      onclick=getPoste(a) style='cursor:pointer;'> " . $posteName . "</span></li>";
                                    }
                                }
                                $html .= '</ul>';
                                $html .= "</li>";
                            }
                            return $html;
                        }
                        echo createArborescenceListeDiff()
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body card-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal large -->
<div class="modal fade" id="displayerModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Poste</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" id="addPostOrContact" name="addPostOrContact" method="POST">
                <div class="modal-body">
                    <div class="card-body card-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php' ?>