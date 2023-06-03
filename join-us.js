$(document).ready(function() {
    $("#register-form").on('submit', function(e) {
        e.preventDefault();
        createUser(this);
    })
})

function createUser(userData) {
    $.ajax({
        type: "POST",
        url: 'server/create-user.php',
        data: new FormData(userData),
        contentType: false,
        cache: false,
        processData: false,
        success: function(r) {
            console.log(r);
            var result;
            try {
                var result = JSON.parse(r);
            }
            catch(error) {
                $("#error-message").text("Wystąpił nieoczekiwany błąd po stronie serwera. Proszę spróbować jeszcze raz.");
                return;
            }
            
            if (result.success) {
                finishRegistration();
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
}

function finishRegistration() {

}