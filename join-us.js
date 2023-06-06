$(document).ready(function() {
    $("#register-form").on('submit', function(e) {
        e.preventDefault();
        createUser(this);
    });

    $("#name-form").on('input', function(e) {
        var getElement = $("#name-form");
        var getInputValue = getElement.children("input").val();
        var getErrorElement = getElement.children(".js-error-message");
        const regexMin = /^(?=.{3,}$)[a-zA-Z0-9_]+$/;
        const regexMax = /^(?=.{,20}$)[a-zA-Z0-9_]+$/;

        if (!regexMin.test(getInputValue)) {
            getErrorElement.text("Hasło jest zbyt krótkie.");
        }
        else {

        }

    })
});

function ShowFormError(getElement, ErrorContent) {
    getElement.children().text(ErrorContent);
    
}

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