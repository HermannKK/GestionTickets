function showPassword(e) {
    if (e) {
        document.getElementById("eyeIcon").innerHTML = '<i class="fa fa-eye"></i>';
    } else {
        var input = document.getElementById("passswordBox");
        if (input.type === "password") {
            input.type = "text";
            document.getElementById("eyeIcon").innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            input.type = "password";
            document.getElementById("eyeIcon").innerHTML = '<i class="fa fa-eye"></i>';
        }
    }
}