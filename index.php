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
                        require_once('Traits/Index/index.php');
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

                            <p><label>Statut :&nbsp </label><span id="status"></span></p>
                            <p><label>Date de mise à jour :&nbsp </label><span id="updateDate"></span></p>
                            <p><label>TAG :&nbsp </label><span id="tag"></span></p>
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
                                    id="secTel">mail</span></p>
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
                <h5 class="modal-title" id="largeModalLabel">Ajouter un poste</h5>
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