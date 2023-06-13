let label = document.querySelector("#showPasswd");
label.addEventListener("click", function () {
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

$(document).ready(function() {
    $("#login-form").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'server/login-user.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(r) {
                grecaptcha.reset($(".g-recaptcha")[0]);
                console.log(r);
                var result;
                try {
                    var result = JSON.parse(r);
                }
                catch(error) {
                    $("#error-message").text("Wystąpił nieoczekiwany błąd po stronie serwera.<br> Proszę spróbować jeszcze raz.");
                    return;
                }

                if (result.success) {
                    finishLogin();
                    $("#error-message").text();
                }
                else {
                    if (result.error.message == undefined) {
                        $("#error-message").text("Wystąpił nieoczekiwany błąd.");
                        return;
                    }
                    $("#error-message").text(result.error.message);
                }

            }
        });
    });

    function finishLogin() {
        $(location).attr('href',`mainpage.php`);
        // console.log(userID);
    }
});