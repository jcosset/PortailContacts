<?php include 'inc/header.php' ?>

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title-1 m-b-25">Admin - Comptes</h2>
                    <div class="card-body">
                        <button type="button" class="btn btn-success mb-1" data-toggle="modal"
                            data-target="#largeModal">
                            Ajouter un compte
                        </button>
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
                <h5 class="modal-title" id="largeModalLabel">Ajouter un compte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="company" class=" form-control-label">Nom</label>
                        <input type="text" id="name" placeholder="Nom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="vat" class=" form-control-label">VAT</label>
                        <input type="text" id="vat" placeholder="DE1234567890" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="street" class=" form-control-label">Street</label>
                        <input type="text" id="street" placeholder="Enter street name" class="form-control">
                    </div>
                    <div class="row form-group">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="city" class=" form-control-label">City</label>
                                <input type="text" id="city" placeholder="Enter your city" class="form-control">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="postal-code" class=" form-control-label">Postal Code</label>
                                <input type="text" id="postal-code" placeholder="Postal Code" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country" class=" form-control-label">Country</label>
                        <input type="text" id="country" placeholder="Country name" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Confirmer</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal large -->

<?php include 'inc/footer.php' ?>