

function capitalize(s) {
    return s[0].toUpperCase() + s.slice(1);
}

const nullToEmpty = (response) => {
    for (let [key, val] of Object.entries(response)) {
        if (val == null || val == "null") {
            response[key] = ""
        }
    }
}

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

    $(document).on("submit", formAttributeId, function (event) {

        event.preventDefault();
        if ($(formAttributeId)[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            let data = $(formAttributeId).serialize()
            console.log(data);
            defaultPostAjax({ url, data })
        }
        $(formAttributeId).addClass('was-validated');
    });

}

function updateFormModalSubmit({ formAttributeId, url }) {
    $(document).on("submit", formAttributeId, function (event) {

        event.preventDefault();
        if ($(formAttributeId)[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            let data = $(formAttributeId).serialize()
            let id = $("#itemID").data("id")
            console.log(data);
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
        updateFormModalSubmit({ formAttributeId, url })
    }
}

function attachEventListenerDeleteBtn({ buttonAttributeClass, url, confirmMessage }) {

    $(document).on('click', buttonAttributeClass, function (e) {

        let conditionWasConfirm = confirm(confirmMessage)

        if (conditionWasConfirm) {
            let id = $(this).val()
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
    const { label, hidden, isRequired } = data
    let required = isRequired == true ? "required" : ""
    let header = '<div class="row form-group"><div class="col col-md-3">'
    let labelField = `<label for="text-input" class="form-control-label" ${required}>${label}</label></div>`
    let field = fieldFunction(data)
    let inputHeader = '<div class="col-12 col-md-9">'
    let footer = "</div></div>"
    if (!hidden) return header + labelField + inputHeader + field + footer

    return field
}

function modalRowFieldInput({ name, placeholder = "", value = "", iSdisabled = true, isRequired, hidden }) {
    let disabled = iSdisabled == true ? "readonly" : ""
    let required = isRequired == true ? "required" : ""
    let type = hidden ? "hidden" : "text"

    return `<input type="${type}" id="${name}" name="${name}" value="${value}" ${required}
     placeholder="${placeholder}" class="form-control" ${disabled} >`

}
function modalRowFieldTextArea({ name, placeholder = "", value = "", iSdisabled = true, isRequired }) {
    let disabled = iSdisabled == true ? "readonly" : ""
    let required = isRequired == true ? "required" : ""
    return `<textarea type="text" id="${name}" name="${name}" placeholder="${placeholder}"  ${required}
    class="form-control"  ${disabled} >${value}</textarea>`
}
function modalRowDropdownSelectCommun({ label, name, optionsHtml, isRequired }, type) {
    let required = isRequired == true ? "required" : ""
    let multiple = type == "select-multiple" ? "multiple='multiple'" : ""
    return `
   <div class="row form-group"><div class="col col-md-3">
   <label for="vat" class="form-control-label" ${required}>${label}</label></div>
   <div class="col-12 col-md-9">
   <select class="js-select2 js-select-custom" ${multiple}  name="${name}" ${required}>

    ${optionsHtml}
  </select>
  <div class="dropDownSelect2"></div>
  </div>
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
    return `<button type="submit" class="btn btn-primary" id="submit">Confirmer</button>`
}

function modalRowFile({ label, name }) {
    return `<input type="file" name=${name} class="form-control-file">`
}

function modalRowDisplayerFactory(data, type) {

    let val = data.value

    if (val == null || val == undefined || val == "null" || val == "undefined" || val == "") {
        data.value = ""
        data.placeholder = ""

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
    let modal = $("#displayerModal .card-body")
    modal.empty()
    let modalFooter = $("#displayerModal .modal-footer")
    modalFooter.empty()

    modal.append(modalRowDisplayerFactory({ label: "Partenaire", name: "partenaire", iSdisabled: true, value: partenaireName }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Partenaire ID", name: "entiteId", value: parteneaireId, hidden: true }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Nom du poste", name: "nom", placeholder: "Nom du poste", isRequired: true, iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Acronyme", name: "acronyme", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Emplacement", name: "emplacement", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Nom sécrétariat", name: "nom_secretariat", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Prénom sécrétariat", name: "prenom_secretariat", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Email sécrétariat", name: "email_secretariat", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Numéro téléphone sécrétariat", name: "tel_secretariat", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Numéro fixe du poste", name: "tel", iSdisabled: false }, 'input'))
    modal.append(modalRowDisplayerFactory({ label: "Email fonctionnel", name: "email_fonc", iSdisabled: false }, 'input'))
    modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))

    updatePostModalSubmitFactory({ formAttributeId: "form#addPostOrContact", url: "actions_" + typeForm + ".php?type=create" }, "save")

}



function getEntite(id) {
    let modalName = "#largeModalEntite"
    $.ajax({
        type: "GET",
        url: "actions.php?type=get&id=" + id,
        cache: false,
        success: function (response) {
            response = JSON.parse(response)
            nullToEmpty(response)
            // modal.append(modalRowDisplayerFactory({ label: "Photo", name: "photo", placeholder: "", value: response.Photo }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Civilite", name: "civilite", value: capitalize(response.Civilite) }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", placeholder: "", value: response.Nom }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Prenom", name: "prenom", placeholder: "", value: response.Prenom }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Grade", name: "grade", placeholder: "", value: response.Grade }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Email perso", name: "email", placeholder: "", value: response.Email }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Email pro", name: "emailPro", placeholder: "", value: response.email_pro }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Téléphone", name: "telephone", placeholder: "", value: response.telephone }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Statut", name: "statut", placeholder: "", value: response.Statut }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Date de mise à jour", name: "datemaj", placeholder: "", value: response.Date_MAJ }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Commentaire", name: "comment", placeholder: "", value: response.Commentaire }, 'textarea'))
            //   modal.append(modalRowDisplayerFactory({ label: "Commentaire niv 2", name: "commentNiv2", placeholder: "", value: response.commentaire_niv_2 }, 'textarea'))

            $(modalName).find("p#tag").text(response.TAG || "")

            $(modalName).find("span#name").text(response.nom || "")
            $(modalName).find("span#nickname").text(response.acronyme || "")
            let emplacementPostal = response.rue_pos + " " + response.cp_pos + " " + response.ville_pos + " " + response.pays_pos + " " + response.compl_pos
            let emplacementGeo = response.rue_geo + " " + response.cp_geo + " " + response.ville_geo + " " + response.pays_geo + " " + response.compl_geo


            $(modalName).find("span#localisationPos").text(emplacementPostal || "")
            // $(modalName).find("span#localisation").text(emplacement || "")
            $(modalName).find("span#localisationGeo").text(emplacementGeo || "")
            $(modalName).find("span#fonctEmail").text(response.email || "")
            $(modalName).find("span#standard").text(response.tel || "")
            $(modalName).find("span#website").text(response.site || "")


        },
        error: function () {
            alert("Error");
        }
    });
}

function getContact(id) {
    let modalName = "#largeModal"
    $.ajax({
        type: "GET",
        url: "actions_contact.php?type=get&id=" + id,
        cache: false,
        success: function (response) {
            response = JSON.parse(response)

            // modal.append(modalRowDisplayerFactory({ label: "Photo", name: "photo", placeholder: "", value: response.Photo }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Civilite", name: "civilite", value: capitalize(response.Civilite) }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", placeholder: "", value: response.Nom }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Prenom", name: "prenom", placeholder: "", value: response.Prenom }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Grade", name: "grade", placeholder: "", value: response.Grade }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Email perso", name: "email", placeholder: "", value: response.Email }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Email pro", name: "emailPro", placeholder: "", value: response.email_pro }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Téléphone", name: "telephone", placeholder: "", value: response.telephone }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Statut", name: "statut", placeholder: "", value: response.Statut }, 'input'))
            //modal.append(modalRowDisplayerFactory({ label: "Date de mise à jour", name: "datemaj", placeholder: "", value: response.Date_MAJ }, 'input'))
            // modal.append(modalRowDisplayerFactory({ label: "Commentaire", name: "comment", placeholder: "", value: response.Commentaire }, 'textarea'))
            //   modal.append(modalRowDisplayerFactory({ label: "Commentaire niv 2", name: "commentNiv2", placeholder: "", value: response.commentaire_niv_2 }, 'textarea'))

            $(modalName).find("span#civilite").text(response.Civilite || "")
            $(modalName).find("span#firstname").text(response.Nom || "")
            $(modalName).find("span#lastname").text(response.Prenom || "")
            $(modalName).find("span#grade").text(response.Grade || "")

            $(modalName).find("span#status").text(response.Statut || "")

            $(modalName).find("span#updateDate").text(formateDate(response.Date_MAJ) || "")
            $(modalName).find("span#tag").text(response.TAG || "")

            $(modalName).find("span#emailPro").text(response.email_pro || "")
            $(modalName).find("span#niv1info").text(response.Commentaire || "")

            $(modalName).find("span#privateNumber").text(response.telephone || "")
            $(modalName).find("span#privateEmail").text(response.Email || "")
            $(modalName).find("span#niv2info").text(response.commentaire_niv_2 || "")
            $("#largeModal").find("p#tag").text(response.TAG || "")

        },
        error: function () {
            alert("Error");
        }
    });
}

function formateDate(dateInput) {
    if (dateInput == null)
        return false;
    let date = new Date(dateInput);
    return date.getDate() + "-" + (date.getMonth() + 1).toString().padStart(2, "0") + "-" + date.getFullYear();
}

function getPoste(id) {
    // let modal = $("#displayerModal .card-body")
    // modal.parent().parent().find("button[type='submit']").remove()
    // modal.empty()

    let modal = $("#displayerModal .card-body")
    let modalFooter = $("#displayerModal .modal-footer")
    let modalName = "#largeModalPoste"
    modal.empty()
    modalFooter.empty()
    $.ajax({
        type: "GET",
        url: "actions_poste.php?type=get&id=" + id,
        cache: false,
        success: function (response) {
            response = JSON.parse(response)
            nullToEmpty(response)
            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", value: response.Nom }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Acronyme", name: "acronyme", placeholder: "", value: response.acronyme }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Emplacement", name: "emplacement", value: response.emplacement }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email fonctionnel", name: "email_fonc", placeholder: "", value: response.Email_fonctionnel }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Numéro fixe", name: "tel", placeholder: "", value: response.tel }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Nom secrétariat", name: "nom_secretariat", placeholder: "", value: response.email_secretariat }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Prénom secrétariat", name: "prenom_secretariat", placeholder: "", value: response.email_secretariat }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email secrétariat", name: "email_secretariat", placeholder: "", value: response.email_secretariat }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Numéro secrétariat", name: "tel_secretariat", placeholder: "", value: response.tel_secretariat }, 'input'))


            $(modalName).find("p#tag").text(response.TAG || "")

            $(modalName).find("span#name").text(response.Nom || "")
            $(modalName).find("span#nickname").text(response.acronyme || "")

            $(modalName).find("span#fixNumber").text(response.tel || "")
            $(modalName).find("span#localisation").text(response.emplacement || "")
            $(modalName).find("span#fonctEmail").text(response.Email_fonctionnel || "")

            $(modalName).find("p#status").text(response.Statut || "")
            $(modalName).find("p#updateDate").text(formateDate(response.Date_MAJ) || "")



            $(modalName).find("span#niv1info").text(response.Commentaire || "")

            $(modalName).find("span#secTel").text(response.tel_secretariat || "")
            $(modalName).find("span#secEmail").text(response.email_secretariat || "")
            $(modalName).find("span#niv2info").text(response.commentaire_niv_2 || "")
            $(modalName).find("p#tag").text(response.TAG || "")


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
            modal.append(modalRowDisplayerFactory({ label: "Acronyme", name: "acronyme", value: entity.acronyme, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Standard", name: "telephone", value: entity.tel, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email fonctionnel", name: "email", value: entity.email, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Site", name: "site", value: entity.site, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Logo", name: "log", value: entity.logo, iSdisabled: false, isRequired: false }, 'file'))
            modal.append(modalRowDisplayerFactory({ label: "Adresse Géographique", name: "adresseGeo", value: entity.rue_geo, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Complément", name: "complementGeo", value: entity.compl_geo, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Code Postal", name: "CPGeo", value: entity.cp_geo, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "villeGeo", value: entity.ville_geo, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "paysGeo", value: entity.pays_geo, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Adresse Postale", name: "adressePos", value: entity.rue_pos, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Complément", name: "complementPos", value: entity.compl_pos, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Code Postal", name: "CPPos", value: entity.cp_pos, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "villePos", value: entity.ville_pos, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "paysPos", value: entity.pays_pos, iSdisabled: false }, 'input'))
            modal.parent().parent().find(".modal-footer").append(modalRowDisplayerFactory({}, 'submit'))
            modal.append(`<span id="itemID" name="id"  data-id=${entity.id} ></span>`)

            $(".js-select-custom").each(function () {
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

            var optionsHtml = ""
            for (entite of entites) {
                let selected = poste.Entite == entite.id ? "selected" : ""
                optionsHtml += `<option value='${entite.id}' ${selected}>${entite.nom}</option>`

            }
            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", value: poste.Nom, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Entite", name: "entiteId", optionsHtml, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Acronyme", name: "acronyme", value: poste.acronyme, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Emplacement", name: "emplacement", value: poste.emplacement, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email fonctionnel", name: "email_fonc", value: poste.Email_fonctionnel, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Numéro fixe", name: "tel", value: poste.tel, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Nom Secrétariat", name: "nom_secretariat", value: poste.nom_secretariat, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Prenom Secrétariat", name: "prenom_secretariat", value: poste.prenom_secretariat, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email Secrétariat", name: "email_secretariat", value: poste.email_secretariat, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Numéro Secrétariat", name: "tel_secretariat", value: poste.tel_secretariat, iSdisabled: false }, 'input'))

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

    Promise.all([ajaxGetPromise("actions_poste.php?type=get&all_filtered"), ajaxGetPromise("actions_contact.php?type=get&id=" + id + "&filter=default")])
        .then(([postes, contact]) => {

            var optionsHtmlPostes = ""
            for (poste of postes) {
                let selected = contact.Poste_actuel == poste.id ? "selected" : ""
                optionsHtmlPostes += `<option value='${poste.id}' ${selected}>${poste.entitename}\\${poste.Nom}</option>`

            }

            var civilites = ["Madame", "Monsieur", "Autre"]
            var optionsHtmlCivilites = ""
            for (civilite of civilites) {
                let selected = contact.Civilite.toLowerCase() == civilite.toLowerCase() ? "selected" : ""
                optionsHtmlCivilites += `<option value='${civilite}' ${selected}>${civilite}</option>`

            }

            var statuts = ["A mettre à jour", "En attente ", "A jour", "Archivé"]
            var optionsHtmlStatuts = ""
            for (statut of statuts) {
                let selected = contact.Statut.toLowerCase() == statut.toLowerCase() ? "selected" : ""
                optionsHtmlStatuts += `<option value='${statut}' ${selected}>${statut}</option>`

            }


            modal.append(modalRowDisplayerFactory({ label: "Photo", name: "photo", value: contact.Nom, iSdisabled: false, isRequired: false }, 'file'))
            modal.append(modalRowDisplayerFactory({ label: "Civilite", name: "civilite", optionsHtml: optionsHtmlCivilites, isRequired: false }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Nom", name: "nom", value: contact.Nom, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Prénom", name: "prenom", value: contact.Prenom, iSdisabled: false, isRequired: true }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Poste", name: "poste", optionsHtml: optionsHtmlPostes }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Grade", name: "grade", value: contact.Grade, iSdisabled: false }, 'input'))

            modal.append(modalRowDisplayerFactory({ label: "Email pro", name: "emailPro", value: contact.email_pro, iSdisabled: false }, 'input'))

            modal.append(modalRowDisplayerFactory({
                label: "Adresse ID", name: "addressID", value: contact.addressID, iSdisabled: true, hidden: true
            }, 'input'))

            modal.append(modalRowDisplayerFactory({ label: "Tag", name: "tag", value: contact.TAG, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Commentaire", name: "commentaire", value: contact.Commentaire, iSdisabled: false }, 'textarea'))
            modal.append(modalRowDisplayerFactory({ label: "Téléphone portable", name: "telephone", value: contact.telephone, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Email personnelle", name: "email", value: contact.Email, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Adresse personnelle", name: "rue", value: contact.Rue, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Complément", name: "complement", value: contact.Compl, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "CP", name: "cp", value: contact.CP, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Ville", name: "ville", value: contact.Ville, iSdisabled: false }, 'input'))
            modal.append(modalRowDisplayerFactory({ label: "Pays", name: "pays", value: contact.Pays, iSdisabled: false }, 'input'))

            modal.append(modalRowDisplayerFactory({ label: "Commentaire niv 2", name: "commentaireNiv2", value: contact.commentaire_niv_2, iSdisabled: false }, 'textarea'))
            modal.append(modalRowDisplayerFactory({ label: "Statut", name: "statut", optionsHtml: optionsHtmlStatuts }, 'select'))
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

    Promise.all([ajaxGetPromise("actions_poste.php?type=get&all_filtered"), ajaxGetPromise("actions_liste.php?type=get&id=" + listeID + "&filter=default")])
        .then(([postes, modesDiffusion]) => {

            let modesNames = modesDiffusion.modes.split(",")
            let modesIds = modesDiffusion.ids.split(",")

            var optionsHtmlModes = ""
            var optionsHtmlPostes = ""
            modesNames.forEach(async (modeName, i) => {

                optionsHtmlModes += `<option value='${modesIds[i]}' >${modeName}</option>`
            })

            postes.forEach(async (poste) => {
                optionsHtmlPostes += `<option value='${poste.id}' >${poste.entitename}\\${poste.Nom}</option>`
            })

            modal.append(modalRowDisplayerFactory({ label: "Poste", name: "poste", optionsHtml: optionsHtmlPostes, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "Mode de diffusion", name: "mode", optionsHtml: optionsHtmlModes, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "ID Liste", name: "listeID", value: listeID, isRequired: true, hidden: true }, 'input'))

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

            var optionsHtmlPostes = ""
            postes.forEach(async (poste) => {

                optionsHtmlPostes += `<option value='${poste.id}' >${poste.entitename}\\${poste.nom}</option>`
            })

            modal.append(modalRowDisplayerFactory({ label: "Poste à retirer", name: "postes[]", optionsHtml: optionsHtmlPostes, isRequired: true }, 'select-multiple'))
            //modal.append(modalRowDisplayerFactory({ label: "Mode de diffusion", name: "mode", optionsHtml: optionsHtmlModes, isRequired: true }, 'select'))
            modal.append(modalRowDisplayerFactory({ label: "ID Liste", name: "listeID", value: listeID, isRequired: true, hidden: true }, 'input'))

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

            var optionsHtmlModesDefaultSelected = ""
            var optionsHtmlListes = ""
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

            $("select[name='listeID']").change(function () {

                $("select[name='mode']").empty()

                let val = $(this).val();
                let listeSelected = listes.find(l => l.id === val)
                let modesNames = listeSelected.modes.split(",")
                let modesIds = listeSelected.ids.split(",")
                var optionsHtmlModesListeSelected = ""
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
$("input[required]").parent("label").addClass("required");
