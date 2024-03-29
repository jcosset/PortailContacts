<?php include 'inc/header.php';
include 'inc/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function debugScreen($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function getAllModeDiffusion()
{
    require('inc/db.php');
    $stmt = "SELECT id, mode FROM mode_diffusion";
    $stmtPrepare = $db->prepare($stmt);
    $stmtPrepare->execute();
    return $stmtPrepare->fetchAll(PDO::FETCH_ASSOC);
}

function getAllListeDiffusion()
{
    require('inc/db.php');
    $stmt = "SELECT liste.id as id, liste.nom as nom, GROUP_CONCAT(md.mode  SEPARATOR ', ') as mode
  FROM Liste as liste  join liste_mode_diffusion as lmd on liste.id = lmd.listeID  join
  mode_diffusion as md on (md.id = lmd.modeID) group by id order by nom asc
   ";
    $stmtPrepare = $db->prepare($stmt);
    $stmtPrepare->execute();
    return $stmtPrepare->fetchAll(PDO::FETCH_ASSOC);
}

function getListePoste()
{
    require('inc/db.php');
    $stmt = "call liste_poste_recursive()";
    $stmtPrepare = $db->prepare($stmt);
    $stmtPrepare->execute();
    $results =   $stmtPrepare->fetchAll(PDO::FETCH_ASSOC);

    $listes = array(
        'postes' => array(),
    );

    foreach ($results as $item) {
        $listes['postes'][$item['listeID']][] = $item;
    }
    return $listes;
}

$listePostes = getListePoste();
// test()
?>

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title-1 m-b-25">Gestion - Listes</h2>
                    <div class="card-body">
                        <button type="button" class="btn btn-success mb-1" data-toggle="modal"
                            data-target="#largeModal">
                            Ajouter une liste
                        </button>
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

                                    <th>Mode diffusion</th>
                                    <th>Postes associés</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $listes = getAllListeDiffusion();
                                foreach ($listes as $liste) {

                                ?>
                                <tr class="tr-shadow">
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $liste['nom']; ?></td>

                                    <td><?php echo $liste['mode']; ?></td>
                                    <td><?php
                                            if (isset($listePostes["postes"][$liste["id"]])) {
                                                $postes = $listePostes["postes"][$liste["id"]];

                                                foreach ($postes as $poste) {
                                                    echo strtoupper($poste["nom"]) . " > " . $poste["entitename"] . "  >  " . $poste["mode"] . "<br/><br/>";
                                                }
                                            }

                                            ?></td>
                                    <td>
                                    <td>
                                        <div class="table-data-feature">

                                            <form action="downloadCSV.php" method="POST">
                                                <input name="listeID" hidden value=<?php echo $liste["id"]; ?>>
                                                <button class="item" id="downloadForm" type="submit"
                                                    data-toggle="tooltip" data-placement="top" title="download csv">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </form>
                                            <button class="item" data-toggle='modal' data-target='#displayerModal'
                                                onClick="showUpdateListeDiffusionModal(<?= ($liste['id']); ?>)"
                                                data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                            <button class="item deleteListe" value=<?= $liste['id']; ?>
                                                data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                            <button class="item" data-toggle='modal' data-target='#displayerModal'
                                                onClick="showCreatePosteListeDiffusionModal(<?= ($liste['id']); ?>)"
                                                data-placement="top" title="Ajout poste">
                                                <i class="zmdi zmdi-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
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
                <h5 class="modal-title" id="largeModalLabel">Liste</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" id="" name="" method="POST">
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