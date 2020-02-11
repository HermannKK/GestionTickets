state={
    tickets:null
}


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

function changeButtonState(buttonID,buttonText, color){
    submitButton = document.getElementById(buttonID);
    if (submitButton.disabled === false) {
        submitButton.innerHTML = '<div class="spinner-border text-'+ color +'"></div>';
        submitButton.disabled = true;

    } else {
        submitButton.innerHTML = buttonText
        submitButton.disabled = false;
    }
}

function login() {
    email=$("#emailBox").val();
    password=$("#passwordBox").val();
    console.log(password);
    changeButtonState("submitButton","connexion");
    var options ={
        url: "php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "login",
            email: email,
            password: password
        },
        success: function(data, status, xhr) {
            changeButtonState("submitButton","connexion", "primary");
            if(data.error){
                text=data.error.message;
            }
            else{
                text="Une erreur s'est produite";
            }
            document.getElementById("errorField").innerHTML=text;
            if(data.role=="admin"){
                window.location.href="admin/";
            }
            if(data.role=="client"){
                window.location.href="public/";
            }
        },
        error: function(xhr, status, error) {
            changeButtonState("submitButton","connexion", "primary");
            document.getElementById("errorField").innerHTML="Une erreur s'est produite"
        }
    };
    $.ajax(options);
}

function countLetters(){
    var count=$("#textBox").val().length;
    document.getElementById("caracteresRestants").innerHTML=2000-count + " caracteres restants"
}
function resetForm(){
    $('#textBox').val("");
    countLetters();
}

function getTickets(role){
    var options ={
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "getTickets"
        },
        success: function(data, status, xhr) {
            if(isDifferent(state.tickets,data)){
                state.tickets=data.value;
                if(role=="admin"){
                    renderForAdmin(data);
                }
                else{
                    renderForClient(data)
                }
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
}


function renderForClient(data){
        $("#root").empty();
        console.log(data.value);
        $("#loading").hide(500);
        if(data.value.length==0){
            $("#root").append("<div class='mx-auto texteCentre'>Vous n'avez aucun ticket actif</div>");
        }
        else{
            groupedData=reverseObject(state.tickets.groupByDate('dateCreation'));
            groupedData.forEach(element=>{
                key=element.key
                date=splitDate(key);
                $("#root").append("<div id='"+key+"'><div class='date'>"+date.day+"-"+ date.month+"-"+ date.year+"</div></div>");
                _element=element.value;
                _element.forEach(content=>{
                    renderTicket(""+key+"",content);
                })
            })
            $("#ticketList").show(500);
        }
}


function renderForAdmin(data,idGestionnaire){
    console.log(data.value.groupBy("idGestionnaire"));
    console.log(data.value.groupBy("etat"));
    console.log(data.userID)
}

function reverseObject(object) {
    var r = Object.keys(object).sort().reverse()
    var sorted ={}
    r.forEach(k => {
            sorted[k] = object[k]
        });
    var sorted =[]
    r.forEach(k => {
            sorted.push({"key":k ,"value": object[k]})
        });
    return sorted;
  }

function isDifferent(oldData,newData){
    if(JSON.stringify(oldData)!=JSON.stringify(newData)){
        return true
    }
    else{
        return false
    }
}
function submitTicket(){
    message=$("#textBox").val();
    var options ={
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "submitTicket",
            message:message
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

renderTicket=(divID, dataTicket)=>{
    const {idTicket,idClient,idGestionnaire,etat,message,reponse,dateCreation,datePriseEnCharge,dateFermeture,nom}=dataTicket;
    if(dateFermeture){
        date=splitDate(dateFermeture)
    }
    else if(datePriseEnCharge){
        date=splitDate(datePriseEnCharge)
    }
    else if(dateCreation){
        date=splitDate(dateCreation)
    }
    
    if(etat=="ouvert"){
        buttonText='<div class="col-5 disconnect" id="cancel'+idTicket+'" onclick="cancelTicket('+idTicket+')">Annuler</div>';
    }
    else if(etat=="Annulé"){
        buttonText='<div class="col-5 disconnect" id="delete'+idTicket+'" onclick="deleteTicket('+idTicket+')">Supprimer</div>';
    }
    else{
        buttonText='<div class="col-5 disconnect"></div>';
    }
    ticketHTML='<div class="card ticket col" id="'+idTicket+'"><div class="row"><div class="col-6 nom">'+nom+'</div><div class="col-6 heure">'+date.hour+':'+date.minute+'</div></div><div class="row text-wrap text-break p"><span class="description ">'+message+'</span></div><div class="row">'+buttonText+'<div class="col-5 texteEtat">'+etat+'</div><div class="col-2"><div class="etat '+etat+'"></div></div></div></div>';
    $("#"+divID).append(ticketHTML);
}

showTooltip=(fonction,idTicket)=>{
    myTitle="<div class='mx-auto'>Cette action est irreverssible.<br>Veuillez confirmer</div>"
    myContent='<div class="pull-left btn btn-outline-danger">Annuler</div><div class="pull-right btn btn-outline-success" onclick="logThis()">Confirmer</div>'
    $('#'+fonction+idTicket).popover({title: myTitle, content: myContent, html: true, placement: "bottom"}); 
}

logThis=()=>{
    console.log("click")
}
splitDate=(dbDate)=>{
    _year=dbDate.slice(0,4);
    _month=dbDate.slice(4,6);
    _day=dbDate.slice(6,8);
    _hour=dbDate.slice(8,10);
    _minute=dbDate.slice(10,12);
    date={
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
      tempVal=splitDate(val)
      newVal=""+tempVal.year+""+tempVal.month+""+tempVal.day+"";
      val=newVal
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


cancelTicket=(idTicket)=>{
    var options ={
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "cancelTicket",
            idTicket:idTicket
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
hideTicket=(idTicket)=>{
    $("#"+idTicket).hide(300);
}

deleteTicket=(idTicket)=>{
    hideTicket(idTicket)
    var options ={
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "deleteTicket",
            idTicket:idTicket
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