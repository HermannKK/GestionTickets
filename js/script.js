state = {
    isLoading = false
};

function showPassword() {
    var input = document.getElementById("passswordBox");
    if (input.type === "password") {
        input.type = "text";
        document.getElementById("eyeIcon").innerHTML = '<i class="fa fa-eye-slash"></i>';
        document.getElementById("eyeIcon").title = "cacher le mot de passe";
    } else {
        input.type = "password";
        document.getElementById("eyeIcon").innerHTML = '<i class="fa fa-eye"></i>';
        document.getElementById("eyeIcon").title = "Aficher le mot de passe";
    }
}


function handleConnection() {
    state.isLoading = true
    submitButton = document.getElementById("submitButton");
    if (state.isLoading) {
        submitButton.innerHTML = '<div class="spinner-border text-primary"></div>';
        submitButton.disabled = true;
    } else {
        submitButton.innerHTML = 'Connexion'
        submitButton.disabled = fasle;
    }
}