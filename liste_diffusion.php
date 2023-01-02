<?php include "inc/header.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="card-body">
                <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#largeModal">
                    Ajouter une liste
                </button>
            </div>
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
                        function getAllModeDiffusion()
                        {
                            require('inc/db.php');
                            $stmt = "SELECT id, mode FROM mode_diffusion";
                            $stmtPrepare = $db->prepare($stmt);
                            $stmtPrepare->execute();
                            return $stmtPrepare->fetchAll(PDO::FETCH_ASSOC);
                        }

                        function _createButtonEdit($itemId, $name, $type)
                        {
                            return "<button class='item' data-toggle='modal' data-target='#displayerModal'
                             onclick='createPoste(event)' title='Edit'>
                             <i class='zmdi zmdi-plus zmdi-hc-lg text-primary'  data-id=$itemId data-name='$name'
                             data-type='$type'></i></button>";
                        }
                        function createButtonDownload($listeID)
                        {
                            return '<form action="downloadCSV.php" method="POST" style="">
                              <input name="listeID"    hidden value="' . $listeID . '">
                              <button class="item" style="" id="downloadForm" type="submit" data-toggle="tooltip"
                                data-placement="top" title="download csv">
                               <i class="zmdi zmdi-download"  style=""></i>
                          </button>
                        </form>';
                        }

                        function createPosteListe($posteName, $mode)
                        {
                            return  "<li >
                            <select name='mode' id='modeID'> <option value='1'>" . $mode . "</option></select>
                            <span class='item' data-toggle='modal' data-target='#largeModal'
                            onclick=getPoste(a) style='cursor:pointer;'> " . $posteName . "</span></li>";
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
                                        $mode = $poste['mode'];
                                        $html .= createPosteListe($posteName, $mode);
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
                <h5 class="modal-title" id="largeModalLabel">Ajouter une liste</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" id="saveListe" method="POST">
                <div class="modal-body">
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="nom" class=" form-control-label">Nom</label>
                            <input type="text" id="name" name="nom" placeholder="Nom" class="form-control" required>
                        </div>
                        <div class=" form-group">
                            <label for="vat" class="form-control-label">Mode de diffusion</label>

                            <select class="js-select2" name="modes[]" multiple="multiple" required>
                                <?php
                                $modes = getAllModeDiffusion();

                                foreach ($modes as $mode) {
                                    $mode_nom = $mode["mode"];
                                    $mode_id = $mode["id"];
                                    echo "<option value='$mode_id'>$mode_nom</option>";
                                }
                                ?>

                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
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
            <form class="needs-validation" id="updateListe" name="updateListe" method="POST">
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