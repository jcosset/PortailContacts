<?php include "inc/header.php" ?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c1">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-account-o"></i>
                </div>
                <div class="text">
                  <h2>10368</h2>
                  <span>Contacts</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="fas fa-list-alt"></i>
                </div>
                <div class="text">
                  <h2>388,688</h2>
                  <span>Listes</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c3">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-calendar-note"></i>
                </div>
                <div class="text">
                  <h2>1,086</h2>
                  <span>this week</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c4">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-money"></i>
                </div>
                <div class="text">
                  <h2>$1,060,386</h2>
                  <span>total earnings</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
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
                $htmlPoste .= "<li> <button class='$isUpdated' data-toggle='modal' data-target='#largeModal' onclick=getContact($id)> " . $contact['Nom'] . "</button></li>";
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
                  ><span data-toggle='modal' data-target='#largeModal' onclick=getPoste($id) style='cursor:pointer;'>
                  " . $poste['Nom'] . "</span></div>";
                  $htmlPoste .= "<ul class='listree-submenu-items' style='display:block;' >";

                  $htmlPoste .= contactArrayToHtml($menus['contact'], $id);

                  $htmlPoste .= '</ul>';
                  $htmlPoste .= "</li>";;
                } else {
                  $htmlPoste .= "<li ><span class='text-danger' data-toggle='modal' data-target='#largeModal'
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



                      $html .= "<li>" . $name . createButtonEdit($itemId, $name, 'poste') . "</li>";
                    } else if (isset($menu['poste'][$itemId])) {

                      $html .= "<li>";
                      $html .= "<div class='listree-submenu-heading' >" . $name . createButtonEdit($itemId, $name, 'poste') . "</div>";
                      $html .= "<ul class='listree-submenu-items'>";

                      $html .= posteArrayToHtml($menu['poste'], $itemId);

                      $html .= '</ul>';
                      $html .= "</li>";;
                    }
                  }

                  if (isset($menu['parents'][$itemId])) {

                    $name = $menu['items'][$itemId]['nom'];


                    $html .= "<li>";
                    $html .= "<div class='listree-submenu-heading'>" . $name . createButtonEdit($itemId, $name, 'poste') . "</div>";
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