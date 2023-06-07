$(document).ready(function() {
    $("#register-form").on('submit', function(e) {
        e.preventDefault();
        createUser(this);
    });

    $("#name-form").on('input', function(e) {
        var getElement = $("#name-form");
        var getInputValue = getElement.children("input").val();
        // var getErrorElement = getElement.children(".js-error-message");
        // const regexMin = /^(?=.{,2}$)[a-zA-Z0-9_]+$/;
        // const regexMax = /^(?=.{21,}$)[a-zA-Z0-9_]+$/;
        if (getInputValue == "") {
            HideFormError(getElement);
        }
        else if (getInputValue.length < 3) {
            ShowFormError(getElement, "Nazwa użytkownika jest zbyt krótka.")
        }
        else if (getInputValue.length > 20){
            ShowFormError(getElement, "Nazwa użytkownika jest zbyt długa.")
        }
        else {
            HideFormError(getElement)
        }

    })
});

function ShowFormError(getElement, ErrorContent) {
    getElement.children(".js-error-message").text(ErrorContent);
    getElement.children(".warning-icon").css("display", "inline");
    
}


function HideFormError(getElement) {
    getElement.children(".js-error-message").text("");
    getElement.children(".warning-icon").css("display", "none");
    
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
            javascript:grecaptcha.reset($(".g-recaptcha")[0]);
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