<?php include "inc/header.php" ?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="listree">

                        <?php
                        require('inc/db.php');

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
                                $isUpdated = "text-success";
                                $id = $contact['id'];
                                $htmlPoste .= "<li> <button class='$isUpdated' data-toggle='modal' data-target='#largeModal' onclick='getContact($id)'> " . $contact['Nom'] . "</button></li>";
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
                            return "<button class='item' data-toggle='modal' data-target='#displayerModal'  onclick='createPoste(event)' title='Edit'>
              <i class='zmdi zmdi-plus zmdi-hc-lg text-primary'  data-id=$itemId data-name='$name' data-type='$type'></i>
                </button>";
                        }
                        function createButtonDetailsEntite($entiteId)
                        {
                            return "<button class='item' data-toggle='modal' data-target='#largeModalEntite'  onclick='getEntite($entiteId)' >
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

                                            $html .= "<li>" . $name . createButtonEdit($itemId, $name, 'poste') . "  " . createButtonDetailsEntite($itemId) . "</li>";
                                        } else if (isset($menu['poste'][$itemId])) {

                                            $html .= "<li>";
                                            $html .= "<div class='listree-submenu-heading' >" . $name . createButtonEdit($itemId, $name, 'poste') . "  " . createButtonDetailsEntite($itemId) . "</div>";
                                            $html .= "<ul class='listree-submenu-items'>";

                                            $html .= posteArrayToHtml($menu['poste'], $itemId);

                                            $html .= '</ul>';
                                            $html .= "</li>";;
                                        }
                                    }

                                    if (isset($menu['parents'][$itemId])) {

                                        $name = $menu['items'][$itemId]['nom'];

                                        $html .= "<li>";
                                        $html .= "<div class='listree-submenu-heading'>" . "$name"  . createButtonEdit($itemId, $name, 'poste') . "    " . createButtonDetailsEntite($itemId) . "
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
                        echo createMenu(0, $menus)
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

            <div class="modal-body" style="font-size:small">

                <!-- jdj -->
                <div style="display:flex" style="font-size:12px;">
                    <div style="width:50%;background:white;border:solid 1px;">
                        <div style="text-align:center">
                            <div style="width:40%; margin:0 auto;"> <img src="images/photo.png" alt="phooto"></div>

                            <p id="status">statut</p>
                            <p id="updateDate">Date de la dernière mise à jour</p>
                            <p id="tag"></p>
                        </div>
                        <div style="text-align:center">
                            <button type=" button" class="btn btn-secondary">Situation dans l'arbre</button>
                            <button type=" button" class="btn btn-secondary">Editer</button>
                        </div>
                    </div>
                    <div style="width:50%;background:white;border:solid 1px;padding-left:0.4em;line-height:15px;
                    padding-top:0.4em;
                    ">

                        <div>
                            <p><label>Civilite :&nbsp </label><span id="civilite"></span></p>
                            <p><label>Nom :&nbsp </label><span id="firstname"></span></p>
                            <p><label>Prénom :&nbsp </label><span id="lastname"></span></p>
                            <p><label>Grade :&nbsp </label><span id="grade"></span></p>

                        </div>
                        <div style="margin-top:15px;">
                            <p><label>Adresse email :&nbsp </label><span id="emailPro"></span></p>
                            <p><label>Informations niv 1 :&nbsp </label><span id="niv1info"></span></p>

                        </div>

                        <div style="margin-top:15px;">
                            <h5 style="text-align:center">Informations confidentielles</h5>
                            <p><label>Téléphone portable :&nbsp </label><span id="privateNumber"></span></p>
                            <p><label>Adresse email perso :&nbsp </label><span id="privateEmail"></span></p>
                            <p><label>Adresse postale perso :&nbsp </label><span id="privateAdress">
                                    postale</span>
                            </p>
                            <p><label>Informations niv 2 :&nbsp </label><span id="niv2info"></span></p>

                        </div>
                    </div>
                </div>
                <div>
                    <div style="width:100%;background:white;border:solid 1px;text-align:center;padding:15px 0px;">
                        <span>Historiques des postes : </span> <button type=" button" class="btn btn-secondary">Saisir
                            une mobilité</button>


                    </div>
                    <div style="width:100%;display:flex;">
                        <div style="width:50%;height:100px;background:white;border:solid 1px;padding-left:0.4em;">
                            <p>Date de début et date de fin</P>
                            <p>Date de début et date de fin</P>
                            <p>Date de début et date de fin</P>
                        </div>
                        <div style="width:50%;height:100px;background:white;border:solid 1px;padding-left:0.4em;">
                            <p>Intitulé du poste</P>
                            <p>Intitulé du poste</P>
                            <p>Intitulé du poste</P>
                        </div>

                    </div>
                </div>
                <!-- end -->
                <!-- <div class="card-body card-block"></div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="largeModalPoste" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Poste</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="font-size:small">

                <!-- jdj -->
                <div style="display:flex" style="font-size:12px;">
                    <div style="width:50%;background:white;border:solid 1px;">
                        <div style="text-align:center">
                            <p id="partner">Nom du partenaire</p>
                            <div style="width:40%; margin:0 auto;"> <img src="images/photo.png" alt="phooto"></div>
                            <p id="tag">TAG</p>
                        </div>

                    </div>
                    <div style="width:50%;background:white;border:solid 1px;padding-left:0.4em;line-height:15px;
                    padding-top:0.4em;
                    ">

                        <div>
                            <p><label>Nom du poste :&nbsp </label><span id="name"></span></p>
                            <p><label>Acronyme :&nbsp </label><span id="nickname"></span></p>

                        </div>
                        <div style="margin-top:15px;">
                            <p><label>Numéro du poste fixe :&nbsp </label><span id="fixNumber"></span></p>
                            <p><label>Emplacement :&nbsp </label><span id="localisation"></span></p>
                            <p><label>Email fonctionnel du poste fixe :&nbsp </label><span id="fonctEmail"></span></p>

                        </div>

                        <div style="margin-top:15px;">
                            <h5>Secrétariat</h5>
                            <p style="padding-left:40px"><label>Numéro portable :&nbsp </label><span
                                    id="privateNumber">mail</span></p>
                            <p style="padding-left:40px"><label>Email :&nbsp </label><span
                                    id="secEmail">sec@email.fr</span></p>

                        </div>
                    </div>
                </div>
                <div>
                    <div style="width:100%;display:flex;">
                        <div style="width:50%;height:30 ;background:white;border:solid 1px;padding-left:0.4em;">
                            <p>Liste de diffusion :&nbsp</P>
                        </div>
                        <div style="width:50%;height:30px;background:white;border:solid 1px;padding-left:0.4em;">
                            <p>Historique des personnes sur le poste :&nbsp</P>
                        </div>

                    </div>
                    <div style="width:100%;display:flex;">
                        <div style="width:50%;background:white;border:solid 1px;padding-left:0.4em;">
                            <p><label>[Nom de la liste] :&nbsp</label><span>Email</span></p>
                            <p><label>[Nom de la liste] :&nbsp</label><span>Papier+Email</span></p>
                            <p><label>[Nom de la liste] :&nbsp</label><span>Papier</span></p>

                        </div>
                        <div style="width:50%;background:white;border:solid 1px;padding-left:0.4em;">
                            <p>Date début - Date fin : Nom Prénom</P>
                            <p>Date début - Date fin : Nom Prénom</P>
                            <p>Date début - Date fin : Nom Prénom</P>
                        </div>

                    </div>
                </div>
                <!-- end -->
                <!-- <div class="card-body card-block"></div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="largeModalEntite" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Entite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="font-size:small">

                <!-- jdj -->
                <div style="display:flex" style="font-size:12px;">
                    <div style="width:50%;background:white;border:solid 1px;">
                        <div style="text-align:center">
                            <div style="width:40%; margin:0 auto;"> <img src="images/photo.png" alt="phooto"></div>
                            <p id="state">Positionnement</p>
                            <p id="tag">TAG</p>
                        </div>

                    </div>
                    <div style="width:50%;background:white;border:solid 1px;padding-left:0.4em;line-height:15px;
                    padding-top:0.4em;
                    ">

                        <div>
                            <p><label>Nom du partenaire :&nbsp </label><span id="name"></span></p>
                            <p><label>Acronyme :&nbsp </label><span id="nickname"></span></p>
                            <p><label>Adresse postale :&nbsp </label><span id="localisationPos"></span></p>
                            <p><label>Adresse géographique :&nbsp </label><span id="localisationGeo"></span></p>
                            <p><label>Email fonctionnel :&nbsp </label><span id="foncEmail"></span></p>
                            <p><label>Standard :&nbsp </label><span id="standard"></span></p>
                            <p><label>Site internet :&nbsp </label><span id="website"></span></p>


                        </div>

                    </div>
                </div>

                <!-- end -->
                <!-- <div class="card-body card-block"></div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>

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
                <h5 class="modal-title" id="largeModalLabel">Details</h5>
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