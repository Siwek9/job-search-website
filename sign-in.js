let label = document.querySelector("#showPasswd");
label.addEventListener("click", function () {
    console.log("dzilaa");
    let input = document.querySelector("#password");
    if (input.type == "password"){
        input.type = "text"; 
        label.innerHTML = "<i class=\"fa-regular fa-eye\" style=\"color: #658667;\"></i>";
    } 
    else{
        input.type = "password";
        label.innerHTML = "<i class=\"fa-regular fa-eye-slash\" style=\"color: #658667;\"></i>";
    } 
});