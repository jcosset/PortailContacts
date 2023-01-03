<?php include 'inc/header.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'inc/db.php';
include 'crud/contact/contact.php';
include 'crud/liste/liste.php';
include 'crud/poste/poste.php';

?>

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title-1 m-b-25">Contacts - Par Liste</h2>
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
                            <button type="button" class="btn btn-success mb-1" data-toggle="modal"
                                data-target="#largeModal">
                                + Ajouter une liste
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
                    <div class="table-responsive table-responsive-data2">
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
                                    <th>Contacts</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $listelistes = getAllListes();
                                foreach ($listelistes as $liste) {

                                ?>
                                <tr class="tr-shadow">
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $liste['Nom']; ?></td>
                                    <td><?php $listeContact = getContactsFromListe($liste['id']);
                                            foreach ($listeContact as $contactsid) {
                                                //Récupération des infos du contact
                                                $infoContact = getContact($contactsid['id']);
                                                echo '<b>' . strtoupper($infoContact[0]['Nom']) . ' ' . $infoContact[0]['Prenom'] . '</b> - ' . $infoContact[0]['Grade'];
                                                //Récupération du poste du contact
                                                $poste = getContactFromPoste($infoContact[0]['Poste_actuel']);
                                                echo ' - <i>' . $poste[0]['poste'] . ' - ' . $poste[0]['entite'] . '</i><br>';;
                                            }
                                            ?></td>
                                    <td>
                                        <div class="table-data-feature">
                                            <button class="item" data-toggle="tooltip" data-placement="top"
                                                title="Send">
                                                <i class="zmdi zmdi-mail-send"></i>
                                            </button>
                                            <button class="item" data-toggle="tooltip" data-placement="top"
                                                title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                            <button class="item" data-toggle="tooltip" data-placement="top"
                                                title="Delete">
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
            <form action="" method="post" name="add_liste">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">Ajouter une liste</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body card-block">

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Nom</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="nom" name="text-input" placeholder="Nom" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
            <?php
            require('inc/db.php');
            if (isset($_POST['Nom'])) {
                $nomliste = stripslashes($_REQUEST['Nom']);
                $nomliste = mysqli_real_escape_string($con, $nomliste);
                $query = "INSERT INTO Liste (Nom) VALUES ('$nomliste')";
                // Exécuter la requête sur la base de données
                $res = mysqli_query($con, $query);
                if ($res) {
                    echo '<div class="alert alert-success" role="alert">Ajouté avec succès</div>';
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- end modal large -->

</div>
</div>
</div>
<!-- end modal large -->

<?php include 'inc/footer.php' ?>