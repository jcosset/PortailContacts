<?php include 'inc/header.php';
include 'inc/db.php';
include 'crud/contact/contact.php';
include 'crud/poste/poste.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getAllGrade()
{
    require('inc/db.php');
    $stmt = "SELECT grade FROM grade";
    $stmtPrepare = $db->prepare($stmt);
    $stmtPrepare->execute();
    return $stmtPrepare->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title-1 m-b-25">Contacts - Par nom</h2>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--md">
                                <select class="js-select2" name="property">
                                    <option selected="selected">All Properties</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#largeModal">
                                + Ajouter un contact
                            </button>
                            <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                <select class="js-select2" name="type">
                                    <option selected="selected">Export</option>
                                    <option value=" ">Option 1</option>
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
                                    <th>Prenom</th>
                                    <th>Poste</th>
                                    <th>Grade</th>
                                    <th>Email pro</th>
                                    <th>Téléphone portable</th>
                                    <th>Email perso</th>
                                    <th>Statut</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $listecontacts = getAllContacts();
                                foreach ($listecontacts as $contact) {
                                ?>
                                    <tr class="tr-shadow">
                                        <td>
                                            <label class="au-checkbox">
                                                <input type="checkbox">
                                                <span class="au-checkmark"></span>
                                            </label>
                                        </td>
                                        <td><?php echo $contact['Nom']; ?></td>
                                        <td><?php echo $contact['Prenom']; ?></td>
                                        <td><?php
                                            if (getEntiteDetailsOfPoste($contact['Poste_actuel'])) {
                                                $poste = getEntiteDetailsOfPoste($contact['Poste_actuel']);
                                                echo $poste[0]['Nom'] . ' - ' . $poste[0]['entitename'];
                                            } else {
                                                echo "Le poste n'existe pas, ou a été supprimé";
                                            }
                                            ?>

                                        </td>
                                        <td><?php echo $contact['Grade']; ?></td>
                                        <td>
                                            <span class="block-email"><?php echo $contact['email_pro']; ?></span>
                                        </td>
                                        <td>
                                            <?php echo $contact['telephone']; ?>
                                        </td>
                                        <td>
                                            <span class="block-email"><?php echo $contact['Email']; ?></span>
                                        </td>
                                        <td><?php echo $contact['Statut']; ?></td>

                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Send">
                                                    <i class="zmdi zmdi-mail-send"></i>
                                                </button>
                                                <button class="item" data-toggle='modal' data-target='#displayerModal' onClick="showContactModal(<?= ($contact['id']); ?>)" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                                <button class="item deleteContact" value=<?= $contact['id']; ?> data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="More">
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
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Ajouter un contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" id="saveContact" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="card-body card-block">

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class=" form-control-label">Civilite</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select class="js-select2" name="civilite">
                                    <?php

                                    $civilites = ["Madame", "Monsieur"];
                                    foreach ($civilites as $civilite) {
                                        echo "<option value='$civilite'>$civilite</option>";
                                    }
                                    ?>
                                    <option value="Autre" selected="selected">Autre</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>
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
                                <label for="text-input" class="form-control-label">Prénom*</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="prenom" name="prenom" placeholder="Prénom" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Grade</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select class="js-select2" name="grade">
                                    <?php

                                    $grades = getAllGrade();
                                    debugScreen($grades);
                                    foreach ($grades as $grade) {

                                        $gradeName = $grade["grade"];

                                        echo "<option value='$gradeName'>$gradeName</option>";
                                    }

                                    ?>

                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Email pro</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="emailPro" name="emailPro" placeholder="email@pro.com" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="file-input" class=" form-control-label">Photo</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" id="photo" name="photo" class="form-control-file">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class=" form-control-label">Poste</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select class="js-select2" name="poste">
                                    <option value="0" selected="selected">LE POSTE N'EXISTE PAS</option>
                                    <?php

                                    $postes = getAllPostes();
                                    debugScreen($postes);
                                    foreach ($postes as $poste) {

                                        $posteNom = $poste["Nom"];
                                        $posteId = $poste["id"];
                                        $entitename = $poste["entitename"];

                                        echo "<option value='$posteId'>$entitename\\$posteNom</option>";
                                    }

                                    ?>

                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">TAG</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="tag" name="tag" placeholder="TAG" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="textarea-input" class=" form-control-label">Commentaire</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="commentaire" id="commentaire" rows="9" placeholder="..." class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Téléphone portable</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="telephone" name="telephone" placeholder="+33612345678" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Email personnelle</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="email" name="email" placeholder="email@email.com" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Adresse personnelle</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="adresse" name="adresse" placeholder="N° de rue..." class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Complement</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="complement" name="complement" placeholder="Bâtiment, interphone..." class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Code postal</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="CP" name="CP" placeholder="75000..." class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Ville</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="ville" name="ville" placeholder="Ville" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Pays</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="pays" name="pays" placeholder="Pays" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="textarea-input" class=" form-control-label">Commentaire niv 2</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="commentaireNiv2" id="commentaireNiv2" rows="9" placeholder="..." class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal large -->
<div class="modal fade" id="displayerModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="largeModalLabel">Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" id="updateContact" name="updateContact" method="POST">
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
