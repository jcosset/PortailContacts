<?php include 'inc/header.php';
include 'inc/db.php';
include 'crud/entite/entite.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function debugOnScreen($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function getAllPostesWithEntite()
{
    require('inc/db.php');

    $sqlGetAllEntity = "SELECT pos.id,pos.Nom as postename, ent.id as entiteID,
    Email_fonctionnel from Poste as pos join Entite as ent on (pos.Entite=ent.id)
    Order by postename Asc";

    $sqlGetAllEntityPrepare = $db->prepare($sqlGetAllEntity);
    $sqlGetAllEntityPrepare->execute();
    $sqlGetAllEntityResults = $sqlGetAllEntityPrepare->fetchAll(PDO::FETCH_ASSOC);
    return $sqlGetAllEntityResults;
}

//debugOnScreen(getAllPostesWithEntite());
$entitesUnsorted = getAllEntites();
$entites = [];
foreach ($entitesUnsorted as $entiteUnsorted) {
    $entites[$entiteUnsorted["id"]] = $entiteUnsorted;
}

?>

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title-1 m-b-25">Gestion - Postes</h2>
                    <div class="table-data__tool">
                        <!-- <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--md">
                                <select class="js-select2" name="property">
                                    <option selected="selected">All Properties</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div> -->
                        <div class="table-data__tool-right">
                            <button type="button" class="btn btn-success mb-1" data-toggle="modal"
                                data-target="#largeModal">
                                + Ajouter un poste
                            </button>
                            <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                <select class="js-select2" name="type">
                                    <option selected="selected">Export</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive ">
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
                                    <th>Entité</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $listepostes = getAllPostesWithEntite();


                                foreach ($listepostes as $poste) {

                                ?>
                                <tr class="tr-shadow">
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?= $poste['postename'] ?></td>
                                    <td style="word-break:break-word;">
                                        <?= $entites[$poste['entiteID']]['nom'] ?>
                                    </td>

                                    <td>
                                        <span class="block-email"><?php echo $poste['Email_fonctionnel']; ?></span>
                                    </td>
                                    <td>
                                        <div class="table-data-feature">
                                            <button class="item" data-toggle="modal" data-placement="top"
                                                data-target='#displayerModal'
                                                onClick="showAddPosteListeByIdModal(<?= ($poste['id']); ?>)"
                                                title="Ajout liste diffusion">
                                                <i class="zmdi zmdi-format-indent-increase"></i>
                                            </button>
                                            <button class="item" data-toggle='modal' data-target='#displayerModal'
                                                onClick="showPosteModal(<?= ($poste['id']); ?>)" data-placement="top"
                                                title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                            <button class="item deletePoste" value=<?= $poste['id']; ?>
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
<!-- modal large -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="needs-validation" id="savePoste" name="savePoste" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">Ajouter un poste</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Nom*</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="nom" name="nom" placeholder="Nom" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Acronyme</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="acronyme" name="acronyme" placeholder="Acronyme..."
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="textarea-input" class=" form-control-label">Emplacement</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="emplacement" id="emplacement" rows="9" placeholder="..."
                                    class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Numéro Fixe</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="telephone" name="telephone" placeholder="+33142424242"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="email" class=" form-control-label">Email fonctionnel</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="email" name="email" placeholder="email@email.com"
                                    class="form-control">
                            </div>
                        </div>

                        <h3>Secrétariat</h3>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Email Secrétariat</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="email-secretariat" name="email-secretariat"
                                    placeholder="email@email.com" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Numéro Secrétariat</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="trl-secretariat" name="tel-secretariat"
                                    placeholder="+330142424242" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="vat" class=" form-control-label">Entité</label>
                            </div>
                            <!-- rs-select2--dark rs-select2--sm rs-select2--dark2 -->
                            <div class="col-12 col-md-9">
                                <select class="js-select2" name="entiteId" required>

                                    <?php

                                    foreach ($entites as $entite) {
                                        $entite_nom = $entite["nom"];
                                        $entite_id = $entite["id"];
                                        echo "<option value='$entite_id'>$entite_nom</option>";
                                    }

                                    ?>

                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="submit">Ajouter</button>
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
            <form class="needs-validation" id="updatePoste" method="POST">
                <div class="modal-body">
                    <div class="card-body card-block"></div>
                </div>

                <div class="row form-group">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php include 'inc/footer.php' ?>