function showPassword() {
    var input = document.getElementById("passswordBox");
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

function disconnect() {
    changeButtonState("disconnectButton","connexion", "primary");
    var options ={
        url: "php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "disconnect"
        },
        success: function(data, status, xhr) {
            changeButtonState("disconnectButton","deconnexion", "danger");
            if(data.succes){
                window.location.href="../";
            }
            else{
                document.getElementById("errorField").innerHTML=data.error.message;
            }
        },
        error: function(xhr, status, error) {
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

state={
    tickets:null
}

function getTickets(){
    var options ={
        url: "../php/api.php", //type de données attendue
        type: "POST",
        dataType: "json", //type de requette GET ou POST
        data: {
            operation: "getTickets"
        },
        success: function(data, status, xhr) {
                if(isDifferent(state.tickets,data)){
                    state.tickets=data;
                    console.log(state.tickets);
                }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    };
    $.ajax(options);
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
}