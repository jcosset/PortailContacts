<?php include 'inc/header.php';
include 'inc/helpers/debug.php';
include 'inc/db.php';
include 'crud/entite/entite.php';

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
                    <h2 class="title-1 m-b-25">Gestion - Entités</h2>
                    <div class="card-body">
                        <button type="button" class="btn btn-success mb-1" data-toggle="modal"
                            data-target="#largeModal">
                            Ajouter une entité
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </th>
                                    <th>Nom</th>
                                    <th>Identifiant entité</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $listEntite = getAllEntites();
                                $listEntiteById = array();
                                foreach ($listEntite as $b) {
                                    $listEntiteById[$b['id']] = $b;
                                }

                                foreach ($listEntite as $entite) {
                                    $entiteParentNom = "AUCUN";

                                    if (isset($listEntiteById[$entite["uper_id"]]["nom"])) {
                                        $entiteParentNom = $listEntiteById[$entite["uper_id"]]["nom"];
                                    }

                                ?>
                                <tr class="tr-shadow">
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?= $entite['nom']; ?></td>
                                    <td><?= $entite['id']; ?></td>

                                    <td>
                                        <div class="table-data-feature">
                                            <button class="item" data-toggle="tooltip" data-placement="top"
                                                title="Send">
                                                <i class="zmdi zmdi-mail-send"></i>
                                            </button>
                                            <button class="item" data-toggle='modal' data-target='#displayerModal'
                                                onClick="showEntiteModal(<?= ($entite['id']); ?>)" title="Modifier">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>

                                            <button class="item deleteEntite" value=<?= $entite['id']; ?>
                                                data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                            <button class="item" data-toggle="tooltip" data-placement="top"
                                                title="More">
                                                <i class="zmdi zmdi-more"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
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
                <h5 class="modal-title" id="largeModalLabel">Ajouter une entité</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" id="saveEntite" method="POST">
                <div class="modal-body">
                    <div class="card-body card-block">

                        <div class="form-group">
                            <label for="company" class="form-control-label">Nom*</label>
                            <input type="text" id="name" placeholder="Nom" class="form-control" name="nom" required>
                        </div>
                        <div class=" form-group">
                            <label for="vat" class="form-control-label">Entite parent*</label>
                            <!-- rs-select2--dark rs-select2--sm rs-select2--dark2 -->
                            <select class="js-select2" name="uper_id">
                                <option value="0" selected="selected">AUCUNE ENTITE PARENT</option>
                                <?php
                                $entites = getAllEntites();
                                foreach ($entites as $entite) {
                                    $entite_nom = $entite["nom"];
                                    $entite_id = $entite["id"];
                                    echo "<option value='$entite_id'>$entite_nom</option>";
                                }

                                ?>
                                <!-- <option value="1">Option 1</option>
                <option value="2">Option 2</option> -->
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>

                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Acronyme</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="acronyme" name="acronyme" placeholder="Acronyme"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Email</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="email" name="email" placeholder="" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Téléphone</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="telephone" name="telephone" placeholder="+33142424242"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Site</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="site" name="site" placeholder="http://www.exemple.com"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Logo</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="logo" name="logo" placeholder="lien vers logo" class="form-control">
                        </div>
                    </div>
                    <!-- Adresse Geo -->
                    <h4>Adresse Géographique</h4>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Adresse</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="adresseGeo" name="adresseGeo" placeholder="N° de rue..."
                                class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Complement</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="complementGeo" name="complementGeo"
                                placeholder="Bâtiment, interphone..." class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Code Postal</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="CPGeo" name="CPGeo" placeholder="75000..." class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Ville</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="villeGeo" name="villeGeo" placeholder="Ville" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Pays</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="paysGeo" name="paysGeo" placeholder="Pays" class="form-control">
                        </div>
                    </div>


                    <!-- Adresse Postale -->
                    <h4>Adresse Postale</h4>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Adresse</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="adressePos" name="adressePos" placeholder="N° de rue..."
                                class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Complement</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="complementPos" name="complementPos"
                                placeholder="Bâtiment, interphone..." class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Code Postal</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="CPPos" name="CPPos" placeholder="75000" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Ville</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="villePos" name="villePos" placeholder="Ville" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">Pays</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="paysPos" name="paysPos" placeholder="Pays" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submit">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end modal large -->

<div class="modal fade" id="displayerModal" tabindex="-1" role="dialog" aria-labelledby="displayerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="displayerModalLabel">Entite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" id="updateEntite" name="updateEntite" method="POST">
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