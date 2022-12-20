<?php include 'inc/header.php';
include 'inc/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function debugOnScreen($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function get_all_post_with_entite()
{
    require('inc/db.php');

    $sqlGetAllEntity = "SELECT pos.id,pos.Nom as postename, ent.Nom as entitename, Rue, Compl,Ville,CP,
     Pays, Email_fonctionnel from Poste as pos join Entite as ent on (pos.Entite=ent.id) Order by postename Asc";

    $sqlGetAllEntityPrepare = $db->prepare($sqlGetAllEntity);
    $sqlGetAllEntityPrepare->execute();
    $sqlGetAllEntityResults = $sqlGetAllEntityPrepare->fetchAll(PDO::FETCH_ASSOC);
    return $sqlGetAllEntityResults;
}

function get_all_entite()
{
    require('inc/db.php');
    $sqlGetAllEntity = "SELECT id, nom, uper_id from Entite order by nom ASC";
    $sqlGetAllEntityPrepare = $db->prepare($sqlGetAllEntity);
    $sqlGetAllEntityPrepare->execute();
    $sqlGetAllEntityResults = $sqlGetAllEntityPrepare->fetchAll(PDO::FETCH_ASSOC);
    return $sqlGetAllEntityResults;
}
// debugOnScreen(get_all_post_with_entite());

?>

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title-1 m-b-25">Gestion - Postes</h2>
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
                                    <th>Entité</th>
                                    <th>Adresse</th>
                                    <th>Pays</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $listepostes = get_all_post_with_entite();
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
                                        <td><?= $poste['entitename'] ?></td>

                                        <td><?php echo $poste['Rue'] . '<br>' . $poste['Compl'] . '<br>' . $poste['CP'] . ' ' . $poste['Ville']; ?></td>
                                        <td><?php echo $poste['Pays']; ?></td>
                                        <td>
                                            <span class="block-email"><?php echo $poste['Email_fonctionnel']; ?></span>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Send">
                                                    <i class="zmdi zmdi-mail-send"></i>
                                                </button>
                                                <button class="item" data-toggle='modal' data-target='#displayerModal'  onClick="showPosteModal(<?= ($poste['id']); ?>)" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                                <button class="item deletePoste" value=<?= $poste['id']; ?>  data-toggle="tooltip" data-placement="top" title="Delete">
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
                                <label for="text-input" class=" form-control-label">Nom</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="nom" name="nom" placeholder="Nom" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Rue</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="rue" name="rue" placeholder="44 rue de Paris" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Complément</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="complement" name="complement" placeholder="Bureau 55B" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">CP</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="cp" name="cp" placeholder="75000" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Ville</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="ville" name="ville" placeholder="Paris" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Pays</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="pays" name="pays" placeholder="France" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="email" class=" form-control-label">Email fonctionnel</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="email" name="email" placeholder="email@email.com" class="form-control" required>
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
                                    $entites = get_all_entite();
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
<div class="modal fade" id="displayerModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="largeModalLabel">Entite</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="needs-validation" id="updatePoste" name="updateEntite" method="POST">
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