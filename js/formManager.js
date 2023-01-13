function defaultPostAjax({ url, data }) {
    $.ajax({
        type: "POST",
        url,
        data,
        success: function (response) {
            window.location.reload();
        },
        error: function () {
            alert("Error");
        }
    });

}
function saveFormModalSubmit({ formAttributeId, url }) {

    $(formAttributeId).submit(function (event) {

        console.log($(formAttributeId).serialize())
        event.preventDefault();
        if ($(formAttributeId)[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            let data = $(formAttributeId).serialize()
            defaultPostAjax({ url, data })
        }
        $(formAttributeId).addClass('was-validated');
    });

}

function updateFormModalSubmit({ formAttributeId, url }) {
    console.log(formAttributeId, url, "updateFormModalSubmit")

    $(document).on("submit", formAttributeId, function (event) {
        console.log(formAttributeId, url, "updateFormModalSubmit")

        console.log($("form#addPosteListeByd").serialize())
        event.preventDefault();
        if ($(formAttributeId)[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            let data = $(formAttributeId).serialize()
            let id = $("#itemID").data("id")
            console.log(id)

            console.log($(formAttributeId).serialize())
            if (id) data = data + "&id=" + id,
                defaultPostAjax({ url, data })
        }
        $(formAttributeId).addClass('was-validated');
    });


    // $(formAttriuteId).submit(function (event) {
    //     console.log(formAttributeId, url, "updateFormModalSubmit")

    //     console.log($("form#addPosteListeByd").serialize())
    //     event.preventDefault();
    //     if ($(formAttributeId)[0].checkValidity() === false) {
    //         event.stopPropagation();
    //     } else {
    //         let data = $(formAttributeId).serialize()
    //         let id = $("#itemID").data("id")
    //         console.log(id)

    //         console.log($(formAttributeId).serialize())
    //         if (id) data = data + "&id=" + id,
    //             defaultPostAjax({ url, data })
    //     }
    //     $(formAttributeId).addClass('was-validated');
    // });

}

function updatePostModalSubmitFactory({ formAttributeId, url }, action = "save") {
    if (action == "save") {
        saveFormModalSubmit({ formAttributeId, url })
    } else if (action == "update") {
        console.log(formAttributeId, url)
        updateFormModalSubmit({ formAttributeId, url })
    }
}

function attachEventListenerDeleteBtn({ buttonAttributeClass, url, confirmMessage }) {

    $(document).on('click', buttonAttributeClass, function (e) {

        let conditionWasConfirm = confirm(confirmMessage)

        if (conditionWasConfirm) {
            let id = $(this).val()
            console.log(id)
            $.ajax({
                type: "POST",
                url: url + "&id=" + id,
                cache: false,
                data: { conditionWasConfirm },
                success: function (response) {
                    window.location.reload();
                },
                error: function () {
                    alert("Error");
                }
            });
        }
    });
}

(function ($) {
    // USE STRICT
    "use strict";
    let deleteEntiteWaringMsg = "En cas de suppression, tous les postes seront également supprimés et les agents en position 'Non affecté'";
    let defaultDeleteWarningMsg = "Êtes-vous sûr ?"

    updatePostModalSubmitFactory({ formAttributeId: "form#saveEntite", url: "actions.php?type=create" })
    updatePostModalSubmitFactory({ formAttributeId: "form#updateEntite", url: "actions.php?type=update" }, "update")
    attachEventListenerDeleteBtn({ buttonAttributeClass: "table button.deleteEntite", url: "actions.php?type=delete", confirmMessage: deleteEntiteWaringMsg })


    updatePostModalSubmitFactory({ formAttributeId: "form#savePoste", url: "actions_poste.php?type=create" })
    updatePostModalSubmitFactory({ formAttributeId: "form#updatePoste", url: "actions_poste.php?type=update" }, "update")
    attachEventListenerDeleteBtn({ buttonAttributeClass: "table button.deletePoste", url: "actions_poste.php?type=delete", confirmMessage: defaultDeleteWarningMsg })

    updatePostModalSubmitFactory({ formAttributeId: "form#saveContact", url: "actions_contact.php?type=create" })
    updatePostModalSubmitFactory({ formAttributeId: "form#updateContact", url: "actions_contact.php?type=update" }, "update")


    attachEventListenerDeleteBtn({ buttonAttributeClass: "table button.deleteContact", url: "actions_contact.php?type=delete", confirmMessage: defaultDeleteWarningMsg })

    updatePostModalSubmitFactory({ formAttributeId: "form#saveListe", url: "actions_liste.php?type=create" })
    attachEventListenerDeleteBtn({ buttonAttributeClass: "table button.deleteListe", url: "actions_liste.php?type=delete", confirmMessage: defaultDeleteWarningMsg })

})(jQuery);

function modalRowFieldWrapWithHeaderAndFooter(fieldFunction, data) {
    const { label } = data
    let header = '<div class="form-group"><div class="col col-md-3">'
    let labelField = `<label for="text-input" class="form-control-label">${label}</label></div>`
    let field = fieldFunction(data)
    let inputHeader = '<div class="col-12 col-md-9">'
    let footer = "</div></div>"
    return header + labelField + inputHeader + field + footer
}

function modalRowFieldInput({ name, placeholder, value = "", iSdisabled = true, isRequired }) {
    let disabled = iSdisabled == true ? "readonly" : ""
    let required = isRequired == true ? "required" : ""
    return `<input type="text" id="${name}" name="${name}" value="${value}" ${required}
     placeholder="${placeholder}" class="form-control" ${disabled} >`

}
function modalRowFieldTextArea({ name, placeholder, value = "", iSdisabled = true, isRequired }) {
    let disabled = iSdisabled == true ? "readonly" : ""
    let required = isRequired == true ? "required" : ""
    return `<textarea type="text" id="${name}" name="${name}" placeholder="${placeholder}"  ${required}
    class="form-control"  ${disabled} >${value}</textarea>`
}
function modalRowDropdownSelectCommun({ label, name, optionsHtml, isRequired }, type) {
    let required = isRequired == true ? "required" : ""
    let multiple = type == "select-multiple" ? "multiple='multiple'" : ""
    return `
   <div class="form-group col-12 col-md-9">
   <label for="vat" class="form-control-label">${label}</label>
   <select class="js-select2 js-select-custom" ${multiple}  name="${name}" ${required}>

    ${optionsHtml}
  </select>
  <div class="dropDownSelect2"></div>
  </div>
  `
}

function modalRowDropdownSelect(data) {
    return modalRowDropdownSelectCommun(data, "select")
}
function modalRowDropdownSelectMultiple(data) {
    return modalRowDropdownSelectCommun(data, "select-multiple")
}


function modalRowButton({ label, name, defaultChoice, optionsHtml }) {
    return `<button type="submit" class="btn btn-primary" id="submit">Confirm</button>`
}

function modalRowFile({ label, name }) {
    return `<input type="file" name=${name} class="form-control-file">`
}

function modalRowDisplayerFactory(data, type) {

    let val = data.value
    if (val == null || val == undefined || val == "null" || val == "undefined" || val.trim() == "") {
        data.value = ""
        data.placeholder = ""
        console.log(data.label, data.value)
    }

    if (type == "input") {
        return modalRowFieldWrapWithHeaderAndFooter(modalRowFieldInput, data)
    }
    if (type == "textarea") {
        return modalRowFieldWrapWithHeaderAndFooter(modalRowFieldTextArea, data)
    }
    if (type == "select") {
        return modalRowDropdownSelect(data)
    }
    if (type == "select-multiple") {
        return modalRowDropdownSelectMultiple(data)
    }
    if (type == "submit") {
        return modalRowButton(data)
    }
    if (type == "file") {
        return modalRowFieldWrapWithHeaderAndFooter(modalRowFile, data)
    }

}

function createPoste(agrs) {
    // const [id, partenaireName] = agrs
    let parteneaireId = agrs.target.getAttribute("data-id")
    let partenaireName = agrs.target.getAttribute("data-name")
    let typeForm = agrs.target.getAttribute("data-type")
    console.log(typeForm)
    let modal = $("#displayerModal .card-body")
    modal.empty()
    let modalFooter = $("#displayerModal .modal-footer")
    modalFooter.empty()

    modal.append(modalRowDisplayerFactory({ label: "Partenaire", name: "partenaire", iSdisabled: true, value: partenaireName }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Partenaire ID", name: "entiteId", iSdisabled: true, value: parteneaireId }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", placeholder: "Nom", isRequired: true, iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Rue", name: "rue", placeholder: "rue", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Complement", name: "complement", placeholder: "complement", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "CP", name: "cp", placeholder: "code postale", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Ville", name: "ville", placeholder: "ville", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Pays", name: "pays", placeholder: "pays", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Email fonctionnel", name: "email", placeholder: "email@email.fr", iSdisabled: false }, 'input'))
    modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))

    updatePostModalSubmitFactory({ formAttributeId: "form#addPostOrContact", url: "actions_" + typeForm + ".php?type=create" }, "save")

}

function getContact(id) {
    let modal = $("#largeModal .card-body")
    modal.empty()
    $.ajax({
        type: "GET",
        url: "actions_contact.php?type=get&id=" + id,
        cache: false,
        success: function (response) {
            response = JSON.parse(response)
            console.log(response)

            modal.append(modalRowDisplayerFactory({ label: "Photo", name: "photo", placeholder: "", value: response.Photo }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", placeholder: "", value: response.Nom }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Prenom", name: "prenom", placeholder: "", value: response.Prenom }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Grade", name: "grade", placeholder: "", value: response.Grade }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email perso", name: "email", placeholder: "", value: response.Email }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email pro", name: "emailPro", placeholder: "", value: response.email_pro }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Téléphone", name: "telephone", placeholder: "", value: response.telephone }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Statut", name: "statut", placeholder: "", value: response.Statut }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Date de mise à jour", name: "datemaj", placeholder: "", value: response.Date_MAJ }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Commentaire", name: "comment", placeholder: "", value: response.Commentaire }, 'textarea'))
            modal.append(modalRowDisplayerFactory({ label: "Commentaire niv 2", name: "commentNiv2", placeholder: "", value: response.commentaire_niv_2 }, 'textarea'))

        },
        error: function () {
            alert("Error");
        }
    });
}

function getPoste(id) {
    let modal = $("#displayerModal .card-body")
    modal.parent().parent().find("button[type='submit']").remove()
    modal.empty()
    $.ajax({
        type: "GET",
        url: "actions_poste.php?type=get&id=" + id,
        cache: false,
        success: function (response) {
            response = JSON.parse(response)
            console.log(response)

            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", value: response.Nom }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Rue", name: "rue", value: response.Rue }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Complement", name: "compl", value: response.Compl }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "CP", name: "cp", value: response.CP }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "ville", value: response.Ville }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "pays", value: response.Pays }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email fonctionnel", name: "email", placeholder: "", value: response.Email_fonctionnel }, 'input'))

        },
        error: function () {
            alert("Error");
        }
    });
}

const ajaxGetPromise = (url) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url,
            cache: false,
            success: function (response) {
                console.log(response)
                resolve(JSON.parse(response))
            },
            error: function () {
                reject("Error")
            }
        });
    })
}

function showEntiteModal(id) {
    let modal = $("#displayerModal .card-body")
    let modalFooter = $("#displayerModal .modal-footer")
    modal.empty()
    modalFooter.empty()

    Promise.all([ajaxGetPromise("actions.php?type=get&all"), ajaxGetPromise("actions.php?type=get&id=" + id)])
        .then(([entites, entity]) => {
            let optionsHtml = ""
            optionsHtml += `<option value='0' >AUCUN PARENT</option>`
            for (entite of entites) {
                let selected = entity.uper_id == entite.id ? "selected='selected'" : ""
                optionsHtml += `<option value='${entite.id}' ${selected}>${entite.nom}</option>`
            }

            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", value: entity.nom, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Entite Parent", name: "uper_id", value: entity.uper_id, optionsHtml, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Acronyme", name: "acronyme", value: entity.acronyme, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Téléphone", name: "telephone", value: entity.tel, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Site", name: "site", value: entity.site, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Logo", name: "logo", value: entity.logo, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Adresse Géographique", name: "adresseGeo", value: entity.rue_geo, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "complement", name: "complementGeo", value: entity.compl_geo, iSdisabled: false, isRequired: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Code Postal", name: "CPGeo", value: entity.cp_geo, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "villeGeo", value: entity.ville_geo, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "paysGeo", value: entity.pays_geo, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Adresse Postale", name: "adressePos", value: entity.rue_pos, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "complement", name: "complementPos", value: entity.compl_pos, iSdisabled: false, isRequired: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Code Postal", name: "CPPos", value: entity.cp_pos, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "villePos", value: entity.ville_pos, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "paysPos", value: entity.pays_pos, iSdisabled: false, isRequired: true }, 'input'))
            modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))
            modal.append(`<span id="itemID" name="id"  data-id=${entity.id} ></span>`)

            $(".js-select2").each(function () {
                $(this).select2({
                    allowClear: true,
                    placeholder: "Selectionner une option",
                    // minimumResultsForSearch: 20,
                    dropdownParent: $(this).next('.dropDownSelect2'),
                    dropdownAutoWidth: true
                });
            });
        })
        .catch(err => console.log(err))
}

function showPosteModal(id) {
    let modal = $("#displayerModal .card-body")
    let modalFooter = $("#displayerModal .modal-footer")
    modal.empty()
    modalFooter.empty()

    Promise.all([ajaxGetPromise("actions.php?type=get&all"), ajaxGetPromise("actions_poste.php?type=get&id=" + id)])
        .then(([entites, poste]) => {

            optionsHtml = ""
            for (entite of entites) {
                let selected = poste.Entite == entite.id ? "selected" : ""
                optionsHtml += `<option value='${entite.id}' ${selected}>${entite.Nom}</option>`

            }
            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", value: poste.Nom, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Entite", name: "entiteId", optionsHtml, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Rue", name: "rue", value: poste.Rue, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Complement", name: "complement", value: poste.Compl, iSdisabled: false, isRequired: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "CP", name: "cp", value: poste.CP, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "ville", value: poste.Ville, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "pays", value: poste.Pays, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email fonctionnel", name: "email", value: poste.Email_fonctionnel, iSdisabled: false, isRequired: true }, 'input'))

            modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))
            modal.append(`<span id="itemID" name="id"  data-id=${poste.id} ></span>`)

            $(".js-select-custom").each(function () {
                $(this).select2({
                    allowClear: true,
                    placeholder: "Selectionner une option",
                    // minimumResultsForSearch: 20,
                    dropdownParent: $(this).next('.dropDownSelect2'),
                    dropdownAutoWidth: true
                });
            });

        }).catch(err => console.log(err))
}

function showContactModal(id) {
    let modal = $("#displayerModal .card-body")
    let modalFooter = $("#displayerModal .modal-footer")
    modal.empty()
    modalFooter.empty()

    console.log(modal)

    Promise.all([ajaxGetPromise("actions_poste.php?type=get&all"), ajaxGetPromise("actions_contact.php?type=get&id=" + id + "&filter=default")])
        .then(([postes, contact]) => {

            optionsHtml = ""
            for (poste of postes) {
                let selected = contact.Poste == poste.id ? "selected" : ""
                let parent1 = poste.entiteParent1 == "null" ? poste.entiteParent1 + "\\" : ""
                optionsHtml += `<option value='${poste.id}' ${selected}>${parent1}${poste.entiteParent0}\\${poste.Nom}</option>`

            }
            modal.append(modalRowDisplayerFactory({ label: "Photo", name: "photo", value: contact.Nom, iSdisabled: false, isRequired: true }, 'file'))
            modal.append(modalRowDisplayerFactory({ label: "Civilite", name: "civilite", value: contact.Civilite, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", value: contact.Nom, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Prénom", name: "prenom", value: contact.Prenom, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Poste", name: "poste", optionsHtml, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Grade", name: "grade", value: contact.Grade, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email", name: "email", value: contact.Email, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email pro", name: "emailPro", value: contact.email_pro, iSdisabled: false, isRequired: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Téléphone", name: "telephone", value: contact.telephone, iSdisabled: false, isRequired: false }, 'input'))

            modal.append(modalRowDisplayerFactory({ label: "Rue", name: "rue", value: contact.Rue, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Complement", name: "complement", value: contact.Compl, iSdisabled: false, isRequired: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "CP", name: "cp", value: contact.CP, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "ville", value: contact.Ville, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "pays", value: contact.Pays, iSdisabled: false, isRequired: true }, 'input'))

            modal.append(modalRowDisplayerFactory({ label: "adresse ID", name: "addressID", value: contact.addressID, iSdisabled: false }, 'input'))

            modal.append(modalRowDisplayerFactory({ label: "Tag", name: "tag", value: contact.TAG, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Commentaire", name: "commentaire", value: contact.Commentaire, iSdisabled: false, isRequired: false }, 'textarea'))
            modal.append(modalRowDisplayerFactory({ label: "Commentaire niv 2", name: "commentaireNiv2", value: contact.commentaire_niv_2, iSdisabled: false, isRequired: false }, 'textarea'))

            modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))
            modal.append(`<span id="itemID" name="id"  data-id=${contact.id} ></span>`)

            $(".js-select-custom").each(function () {
                $(this).select2({
                    allowClear: true,
                    placeholder: "Selectionner une option",
                    // minimumResultsForSearch: 20,
                    dropdownParent: $(this).next('.dropDownSelect2'),
                    dropdownAutoWidth: true
                });
            });

        }).catch(err => console.log(err))

}

function showCreatePosteListeDiffusionModal(listeID) {

    let modal = $("#displayerModal .card-body")
    let modalFooter = $("#displayerModal .modal-footer")

    $("#displayerModal form").attr("id", "addPosteListe");

    modal.empty()
    modalFooter.empty()

    updatePostModalSubmitFactory({ formAttributeId: "form#addPosteListe", url: "actions_liste.php?type=addPoste" })

    Promise.all([ajaxGetPromise("actions_poste.php?type=get&all"), ajaxGetPromise("actions_liste.php?type=get&id=" + listeID + "&filter=default")])
        .then(([postes, modesDiffusion]) => {

            let modesNames = modesDiffusion.modes.split(",")
            let modesIds = modesDiffusion.ids.split(",")

            optionsHtmlModes = ""
            optionsHtmlPostes = ""
            modesNames.forEach(async (modeName, i) => {

                optionsHtmlModes += `<option value='${modesIds[i]}' >${modeName}</option>`
            })

            postes.forEach(async (poste) => {
                let parent1 = poste.entiteParent1 == "null" ? poste.entiteParent1 + "\\" : ""
                optionsHtmlPostes += `<option value='${poste.id}' >${parent1}${poste.entiteParent0}\\${poste.Nom}</option>`
            })

            modal.append(modalRowDisplayerFactory({ label: "Poste", name: "poste", optionsHtml: optionsHtmlPostes, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Mode de diffusion", name: "mode", optionsHtml: optionsHtmlModes, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "ID Liste", name: "listeID", value: listeID, iSdisabled: true, isRequired: true }, 'input'))

            modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))

            $(".js-select-custom").each(function () {
                $(this).select2({
                    allowClear: true,
                    placeholder: "Selectionner une option",
                    // minimumResultsForSearch: 20,
                    dropdownParent: $(this).next('.dropDownSelect2'),
                    dropdownAutoWidth: true
                });
            });

        }).catch(err => console.log(err))

}

function showUpdateListeDiffusionModal(listeID) {

    let modal = $("#displayerModal .card-body")
    let modalFooter = $("#displayerModal .modal-footer")

    $("#displayerModal form").attr("id", "updateListe");

    modal.empty()
    modalFooter.empty()

    updatePostModalSubmitFactory({ formAttributeId: "form#updateListe", url: "actions_liste.php?type=update" })

    Promise.all([ajaxGetPromise("actions_liste.php?type=getPoste&id=" + listeID)])
        .then(([postes]) => {

            // let modesNames = ["helloe", "test"]
            // let modesIds = ["helloe", "test"]

            // optionsHtmlModes = ""

            // modesNames.forEach(async (modeName, i) => {

            //     optionsHtmlModes += `<option value='${modesIds[i]}' >${modeName}</option>`
            // })

            optionsHtmlPostes = ""
            postes.forEach(async (poste) => {
                let parent1 = poste.entiteParent1 == "null" ? poste.entiteParent1 + "\\" : ""
                optionsHtmlPostes += `<option value='${poste.id}' >${parent1}${poste.entiteParent0}\\${poste.Nom}</option>`
            })

            modal.append(modalRowDisplayerFactory({ label: "Poste à retirer", name: "postes[]", optionsHtml: optionsHtmlPostes, isRequired: true }, 'select-multiple'))
            //modal.append(modalRowDisplayerFactory({ label: "Mode de diffusion", name: "mode", optionsHtml: optionsHtmlModes, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "ID Liste", name: "listeID", value: listeID, iSdisabled: true, isRequired: true }, 'input'))

            modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))

            $(".js-select-custom").each(function () {
                $(this).select2({
                    allowClear: true,
                    placeholder: "Selectionner une option",
                    // minimumResultsForSearch: 20,
                    dropdownParent: $(this).next('.dropDownSelect2'),
                    dropdownAutoWidth: true
                });
            });

        }).catch(err => console.log(err))

}

function showAddPosteListeByIdModal(posteID) {

    console.log("click showAddPosteListeByd")
    // $("#displayerModal form#updatePoste").off("submit")
    let modal = $("#displayerModal .card-body")
    let modalFooter = $("#displayerModal .modal-footer")

    $("#displayerModal form").prop("id", "addPosteListeByd");

    updatePostModalSubmitFactory({ formAttributeId: "form#addPosteListeByd", url: "actions_liste.php?type=addPoste" })
    modal.empty()
    modalFooter.empty()
    modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))

    Promise.all([ajaxGetPromise("actions_liste.php?type=get&all")])
        .then(([listes]) => {

            optionsHtmlModesDefaultSelected = ""
            optionsHtmlListes = ""
            listes.forEach(async (liste) => {
                optionsHtmlListes += `<option value='${liste.id}' >${liste.nom}</option>`
            })

            let modesNames = listes[0].modes.split(",")
            let modesIds = listes[0].ids.split(",")
            modesNames.forEach(async (modeName, i) => {

                optionsHtmlModesDefaultSelected += `<option value='${modesIds[i]}' >${modeName}</option>`
            })

            modal.append(modalRowDisplayerFactory({ label: "Liste diffusion", name: "listeID", optionsHtml: optionsHtmlListes, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Mode de diffusion", name: "mode", optionsHtml: optionsHtmlModesDefaultSelected, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "ID Poste", name: "poste", value: posteID, iSdisabled: true, isRequired: true }, 'input'))

            $("select[name='liste']").change(function () {

                $("select[name='mode']").empty()

                let val = $(this).val();
                let listeSelected = listes.find(l => l.id === val)
                let modesNames = listeSelected.modes.split(",")
                let modesIds = listeSelected.ids.split(",")
                optionsHtmlModesListeSelected = ""
                modesNames.forEach(async (modeName, i) => {
                    optionsHtmlModesListeSelected += `<option value='${modesIds[i]}' >${modeName}</option>`
                })


                $("select[name='mode']").html(optionsHtmlModesListeSelected)
            });

            $(".js-select-custom").each(function () {
                $(this).select2({
                    allowClear: true,
                    placeholder: "Selectionner une option",
                    dropdownParent: $(this).next('.dropDownSelect2'),
                    dropdownAutoWidth: true
                });
            });

        }).catch(err => { console.log(err); })

}
