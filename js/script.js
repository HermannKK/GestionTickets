function showPassword() {
    var input = document.getElementById("passwordBox");
    if (input.type === "password") {
        input.type = "text";
        document.getElementById("eyeIcon").innerHTML = '<i class="fa fa-eye-slash pointerOnHover"></i>';
        document.getElementById("eyeIcon").title = "cacher le mot de passe";
    } else {
        input.type = "password";
        document.getElementById("eyeIcon").innerHTML = '<i class="fa fa-eye pointerOnHover"></i>';
        document.getElementById("eyeIcon").title = "Aficher le mot de passe";
    }
}

function changeButtonState(buttonID, buttonText, color) {
    submitButton = document.getElementById(buttonID);
    if (submitButton.disabled === false) {
        submitButton.innerHTML = '<div class="spinner-border text-' + color + '"></div>';
        submitButton.disabled = true;

    } else {
        submitButton.innerHTML = buttonText
        submitButton.disabled = false;
    }
}

function login() {
    email = $("#emailBox").val();
    password = $("#passwordBox").val();
    console.log(password);
    changeButtonState("submitButton", "connexion");
    var options = {
        url: "php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "login",
            email: email,
            password: password
        },
        success: function(data, status, xhr) {
            changeButtonState("submitButton", "connexion", "primary");
            if (data.error) {
                text = data.error.message;
            } else {
                text = "Une erreur s'est produite";
            }
            document.getElementById("errorField").innerHTML = text;
            console.log(data)
            if (data.role == "admin") {
                window.location.href = "admin/";
            }
            if (data.role == "client") {
                window.location.href = "public/";
            }
        },
        error: function(xhr, status, error) {
            changeButtonState("submitButton", "connexion", "primary");
            document.getElementById("errorField").innerHTML = "Une erreur s'est produite"
        }
    };
    $.ajax(options);
}

function countLetters() {
    var count = $("#textBox").val().length;
    document.getElementById("caracteresRestants").innerHTML = 2000 - count + " caracteres restants"
}

function resetForm() {
    $('#textBox').val("");
    countLetters();
}

var state = {
    tickets: null
}

function getTickets(role) {
    var options = {
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "getTickets"
        },
        success: function(data, status, xhr) {
            if (isDifferent(state.tickets, data.value) == true) {
                state.tickets = data.value;
                if (role == "admin") {
                    renderForAdmin(data, data.userID);
                    $('[data-toggle="popover"]').popover();
                } else {
                    renderForClient(data);
                    $('[data-toggle="popover"]').popover();
                }
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
}


function renderForClient(data) {
    $("#root").empty();
    $("#loading").hide(500);
    if (data.value.length == 0) {
        $("#root").append("<div class='mx-auto texteCentre'>Vous n'avez aucun ticket actif</div>");
    } else {
        groupedData = reverseObject(state.tickets.groupByDate('dateCreation'));
        groupedData.forEach(element => {
            key = element.key
            date = splitDate(key);
            $("#root").append("<div id='" + key + "'><div class='date'>" + date.day + "-" + date.month + "-" + date.year + "</div></div>");
            _element = element.value;
            _element.forEach(content => {
                renderTicket("" + key + "", content);
            })
        })
        $("#ticketList").show(500);
    }
}


returnCurrentAdminTickets = (idGestionnaire, sortedData) => {
    var i = 0;
    var data = [];
    for (var j = 0; j < sortedData.length; j++) {
        element = sortedData[i];
        if (element.idGestionnaire == idGestionnaire) {
            data[i] = element;
            i++;
        }
    }
    return data;
}

function renderForAdmin(_data, idGestionnaire) {
    $('[data-toggle="popover"]').popover('hide')
    $(".ticketList").empty();
    $(".loading").hide(500);
    data = _data.value.groupBy("etat");
    ouvert = data.ouvert ? data.ouvert : [];
    ferme = data.fermé ? data.fermé : [];
    _traitement = data.traitement ? data.traitement : [];
    traitement = returnCurrentAdminTickets(idGestionnaire, _traitement);
    if (ouvert.length == 0) {
        $("#openTickets").append("<div class='mx-auto texteCentre'>Aucun ticket actif</div>");
    } else {
        groupedData = reverseObject(ouvert.groupByDate('dateCreation'));
        groupedData.forEach(element => {
            key = element.key
            date = splitDate(key);
            $("#openTickets").append("<div id='open" + key + "'><div class='date'>" + date.day + "-" + date.month + "-" + date.year + "</div></div>");
            _element = element.value;
            _element.forEach(content => {
                renderTicketForAdmin("open" + key + "", content);
            })
        })
        $("#ticketList").show(500);
    }

    if (ferme.length == 0) {
        $("#closedTickets").append("<div class='mx-auto texteCentre'>Aucun ticket actif</div>");
    } else {
        groupedData = reverseObject(ferme.groupByDate('dateCreation'));
        groupedData.forEach(element => {
            key = element.key
            date = splitDate(key);
            $("#closedTickets").append("<div id='closed" + key + "'><div class='date'>" + date.day + "-" + date.month + "-" + date.year + "</div></div>");
            _element = element.value;
            _element.forEach(content => {
                renderTicketForAdmin("closed" + key + "", content);
            })
        })
        $("#ticketList").show(500);
    }

    if (traitement.length == 0) {
        $("#myTickets").append("<div class='mx-auto texteCentre'>Vous n'avez aucun ticket a votre actif</div>");
    } else {
        groupedData = reverseObject(traitement.groupByDate('dateCreation'));
        groupedData.forEach(element => {
            key = element.key
            date = splitDate(key);
            $("#myTickets").append("<div id='my" + key + "'><div class='date'>" + date.day + "-" + date.month + "-" + date.year + "</div></div>");
            _element = element.value;
            _element.forEach(content => {
                renderTicketForAdmin("my" + key + "", content);
            })
        })
        $("#ticketList").show(500);
    }
}

function reverseObject(object) {
    var r = Object.keys(object).sort().reverse()
    var sorted = {}
    r.forEach(k => {
        sorted[k] = object[k]
    });
    var sorted = []
    r.forEach(k => {
        sorted.push({ "key": k, "value": object[k] })
    });
    return sorted;
}

function isDifferent(oldData, newData) {
    if (JSON.stringify(oldData) == JSON.stringify(newData)) {
        return false;
    } else {
        return true;
    }
}


function submitTicket() {
    $('[data-toggle="popover"]').popover('hide')
    message = $("#textBox").val();
    var options = {
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "submitTicket",
            message: message
        },
        success: function(data, status, xhr) {
            console.log(data);

        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
    $("#textBox").val("");
    countLetters()
}

returnFormatedDate = (date) => {
    return "&nbsp;le&nbsp;" + date.day + "-" + date.month + "-" + date.year + " à " + date.hour + ":" + date.minute;
}

renderTicket = (divID, dataTicket) => {
    const { idTicket, idClient, idGestionnaire, etat, message, reponse, dateCreation, datePriseEnCharge, dateFermeture, nom } = dataTicket;
    if (dateFermeture) {
        dateF = splitDate(dateFermeture)
    }
    if (dateCreation) {
        date = splitDate(dateCreation)
    }
    if ((reponse && reponse.length > 150) || message.length > 150) {
        descriptionField = '<div class="col"><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Message</b></div><div class="row" id="message' + idTicket + '">' + message + '</div></div></div><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Reponse </b><span class="ultraLigth"></span> ' + returnFormatedDate(dateF) + '</div><div class="row" id="reponse' + idTicket + '">' + reponse + '</div></div></div></div>'
    } else if (!reponse) {
        descriptionField = '<span class="btop">' + message + '</span>'
    } else {
        descriptionField = '<div class="col"><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Message</b></div><div class="row" id="message' + idTicket + '">' + message + '</div></div></div><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Reponse </b><span class="ultraLigth"></span> ' + returnFormatedDate(dateF) + '</div><div class="row" id="reponse' + idTicket + '">' + reponse + '</div></div></div></div>'
    }

    if (etat == "ouvert") {
        buttonText = '<div title="Attention!" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Cette action est irréversible" class="col-5 disconnect pointerOnHover" id="cancel' + idTicket + '" onclick="cancelTicket(' + idTicket + ')">Annuler</div>';
    } else if (etat == "Annulé" || etat == "fermé") {
        buttonText = '<div title="Attention!" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Cette action est irréversible" class="col-5 disconnect pointerOnHover" id="delete' + idTicket + '" onclick="deleteTicket(' + idTicket + ')">Supprimer</div>';
    } else {
        buttonText = '<div class="col-5"></div>';
    }
    ticketHTML = '<div class="card ticket col" id="' + idTicket + '"><div class="row"><div class="col-6 nom">' + nom + '</div><div class="col-6 heure">' + date.hour + ':' + date.minute + '</div></div><div class="row text-wrap text-break description">' + descriptionField + '</div><div class="row">' + buttonText + '<div class="col-5 texteEtat">' + etat + '</div><div class="col-2"><div class="etat ' + etat + '"></div></div></div></div>';
    $("#" + divID).append(ticketHTML);
}

renderTicketForAdmin = (divID, dataTicket) => {
    const { idTicket, idClient, idGestionnaire, etat, message, reponse, dateCreation, datePriseEnCharge, dateFermeture, nom } = dataTicket;

    if (dateFermeture) {
        dateF = splitDate(dateFermeture)
    } else if (dateCreation) {
        date = splitDate(dateCreation)
    }

    if (etat == "ouvert") {
        buttonText = '<div title="Attention!" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Cette action est irréversible" class="col-5 positive pointerOnHover" id="cancel' + idTicket + '" onclick="takeTicket(' + idTicket + ')">Prendre en charge</div>';
    } else {
        buttonText = '<div class="col-5"></div>';
    }
    if (etat == "traitement") {
        inputBox = "<div class='row mx-auto'><form onsubmit='replyTicket(" + idTicket + ")'><div class='form-group'><div class='input-group'><input class='form-control fitParentWidth' placeholder='Votre reponse' type='text' value='' id='reponseBox" + idTicket + "' required><div class='input-group-append'><div class='btn input-group-text' onClick='replyTicket(" + idTicket + ")' id='sendIcon' title='Envoyer votre reponse'><i title='Attention!' data-toggle='popover' data-placement='top' data-trigger='hover' data-content='Cette action est irréversible' class='fa fa-paper-plane mx-auto'></i></div></div></div></div></form></div>";
        ticketHTML = '<div class="card ticket col" id="' + idTicket + '"><div class="row"><div class="col-6 nom">' + nom + '</div><div class="col-6 heure">' + date.hour + ':' + date.minute + '</div></div><div class="row text-wrap text-break p"><span class="description ">' + message + '</span></div>' + inputBox + '<div class="row">' + buttonText + '<div class="col-5 texteEtat">' + etat + '</div><div class="col-2"><div class="etat ' + etat + '"></div></div></div></div>';
    } else {
        if ((reponse && reponse.length > 150) || message.length > 150) {
            descriptionField = '<div class="col"><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Message</b></div><div class="row" id="message' + idTicket + '">' + message + '</div></div></div><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Reponse </b><span class="ultraLigth"></span> ' + returnFormatedDate(dateF) + '</div><div class="row" id="reponse' + idTicket + '">' + reponse + '</div></div></div></div>'
        } else if (!reponse) {
            descriptionField = '<span class="btop">' + message + '</span>'
        } else {
            descriptionField = '<div class="col"><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Message</b></div><div class="row" id="message' + idTicket + '">' + message + '</div></div></div><div class="row"><div class="col"><div class="row mx-auto texteCentre btop"><b>Reponse </b><span class="ultraLigth"></span> ' + returnFormatedDate(dateF) + '</div><div class="row" id="reponse' + idTicket + '">' + reponse + '</div></div></div></div>'
        }
        ticketHTML = '<div class="card ticket col" id="' + idTicket + '"><div class="row"><div class="col-6 nom">' + nom + '</div><div class="col-6 heure">' + date.hour + ':' + date.minute + '</div></div><div class="row text-wrap text-break description">' + descriptionField + '</div><div class="row">' + buttonText + '<div class="col-5 texteEtat">' + etat + '</div><div class="col-2"><div class="etat ' + etat + '"></div></div></div></div>';
    }
    $("#" + divID).append(ticketHTML);
}

splitDate = (dbDate) => {
    _year = dbDate.slice(0, 4);
    _month = dbDate.slice(4, 6);
    _day = dbDate.slice(6, 8);
    _hour = dbDate.slice(8, 10);
    _minute = dbDate.slice(10, 12);
    date = {
        year: _year,
        month: _month,
        day: _day,
        hour: _hour,
        minute: _minute
    }
    return date;
}

Array.prototype.groupByDate = function(prop) {
    return this.reduce(function(groups, item) {
        var val = item[prop]
        tempVal = splitDate(val)
        newVal = "" + tempVal.year + "" + tempVal.month + "" + tempVal.day + "";
        val = newVal
        groups[val] = groups[val] || []
        groups[val].push(item)
        return groups
    }, {})
}

Array.prototype.groupBy = function(prop) {
    return this.reduce(function(groups, item) {
        const val = item[prop]
        groups[val] = groups[val] || []
        groups[val].push(item)
        return groups
    }, {})
}


cancelTicket = (idTicket) => {
    $('[data-toggle="popover"]').popover('hide')
    var options = {
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "cancelTicket",
            idTicket: idTicket
        },
        success: function(data, status, xhr) {
            console.log(data);
            getTickets();

        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
}

takeTicket = (idTicket) => {
    $('[data-toggle="popover"]').popover('hide');
    var options = {
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "takeTicket",
            idTicket: idTicket
        },
        success: function(data, status, xhr) {
            console.log(data);
            getTickets();

        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
}


hideTicket = (idTicket) => {
    $("#" + idTicket).hide(300);
}

deleteTicket = (idTicket) => {
    $('[data-toggle="popover"]').popover('hide')
    hideTicket(idTicket)
    var options = {
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "deleteTicket",
            idTicket: idTicket
        },
        success: function(data, status, xhr) {
            console.log(data);
            getTickets();
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
}

replyTicket = (idTicket) => {
    $('[data-toggle="popover"]').popover('hide');
    reponse = $("#reponseBox" + idTicket).val();
    hideTicket(idTicket);
    var options = {
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "replyTicket",
            idTicket: idTicket,
            message: reponse
        },
        success: function(data, status, xhr) {
            console.log(data);
            getTickets();
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
}

addUser = () => {
    $("#addUserButton").attr("disabled", true);
    email = $("#emailBox").val();
    password = $("#passwordBox").val();
    name = $("#nameBox").val();
    role = $("#roleBox").val();
    var options = {
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "addUser",
            email: email,
            password: password,
            name: name,
            role: role
        },
        success: function(data, status, xhr) {
            if (data.error.message) {
                document.getElementById("addUserForm").reset();
                document.getElementById("addUserError").innerHTML = data.error.message;
                $('#addUserError').attr('class', 'alert alert-danger');
                $("#addUserButton").attr("disabled", false);
            }
            if (data.success) {
                document.getElementById("addUserForm").reset();
                document.getElementById("addUserError").innerHTML = "Utilisateur ajouté avec succes"
                $('#addUserError').attr('class', 'alert alert-success');
                $("#addUserButton").attr("disabled", false);
                setTimeout($('#addUSer').modal('hide'), 3000)
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
}