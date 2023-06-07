$(document).ready(function() {
    $("#register-form").on('submit', function(e) {
        e.preventDefault();
        createUser(this);
    });

    $("#name-form").on({
        'input': function(e) {
            var htmlElement = $("#name-form");
            var inputValue = htmlElement.children("input").val();
            // var getErrorElement = getElement.children(".js-error-message");

            var nameRegex = /^(?=.{3,20}$)[a-zA-Z0-9_]+$/;

            if (inputValue == "") {
                HideFormError(htmlElement);
            }
            else if (inputValue.length < 3) {
                ShowFormError(htmlElement, "Nazwa użytkownika jest zbyt krótka.");
            }
            else if (inputValue.length > 20){
                ShowFormError(htmlElement, "Nazwa użytkownika jest zbyt długa.");
            }
            else if (!nameRegex.test(inputValue)) {
                ShowFormError(htmlElement, "Niedozwolone znaki w nazwie użytkownika.");
            }
            else {
                HideFormError(htmlElement);
            }

        },
        'change': function(e) {
            // ajax
        }
    });

    $("#email-form").on({
        'input': function() {
            var htmlElement = $("#email-form");
            var inputValue = htmlElement.children("input").val();

            var emailRegex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/

            if (inputValue == "") {
                HideFormError(htmlElement);
            }
            else if (!emailRegex.test(inputValue)) {
                ShowFormError(htmlElement, "Niepoprawny Email.");
            }
            else {
                HideFormError(htmlElement);
            }
        },
        'change': function() {

        }
    });
    
    $("#password-form").on({
        'input': function() {
            var htmlElement = $("#password-form");
            var htmlRepeatElement = $("#password-repeat-form");
            
            var passwordInput = $("#password-form").children("input").val();
            var passwordRepeatInput = $("#password-repeat-form").children("input").val();
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_-])[A-Za-z\d@$!%*?&_-]{8,20}$/;

            if (passwordInput == "") {
                HideFormError(htmlElement);
                HideFormError(htmlRepeatElement);
            }
            else if (passwordInput.length < 8) {
                ShowFormError(htmlElement, "Za krótkie hasło.");
                HideFormError(htmlRepeatElement);
            }
            else if (passwordInput.length > 20) {
                ShowFormError(htmlElement, "Za długie hasło.");
                HideFormError(htmlRepeatElement);
            }
            else if (!passwordRegex.test(passwordInput)) {
                ShowFormError(htmlElement, "Niepoprawne hasło.");
                HideFormError(htmlRepeatElement);
            }
            else if (passwordInput != passwordRepeatInput && passwordRegex.test(passwordRepeatInput)) {
                ShowFormError(htmlElement, "Podane hasła nie są identyczne.");
                ShowFormError(htmlRepeatElement, "Podane hasła nie są identyczne.");
            }
            else {
                HideFormError(htmlElement);
                HideFormError(htmlRepeatElement);
            }
        },
        'change': function() {
            // var htmlElement = $("#password-form");
            // var htmlRepeatElement = $("#password-repeat-form");
            
            // var passwordInput = $("#password-form").children("input").val();
            // var passwordRepeatInput = $("#password-repeat-form").children("input").val();
            // var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_-])[A-Za-z\d@$!%*?&_-]{8,20}$/;

            // if (passwordRepeatInput != "" && passwordRegex.test(passwordInput) && passwordInput != passwordRepeatInput) {
            //     ShowFormError(htmlElement, 'Hasła nie są identyczne');
            //     ShowFormError(htmlRepeatElement, 'Hasła nie są identyczne');
            // }
            // else if (passwordRegex.test(passwordInput)) {
            //     HideFormError(htmlElement);
            //     HideFormError(htmlRepeatElement);
            // }
        }
    });

    $("#password-repeat-form").on({
        'input': function() {
            var htmlElement = $("#password-repeat-form");
            var inputValue = htmlElement.children("input").val();
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_-])[A-Za-z\d@$!%*?&_-]{8,20}$/;

            if (inputValue == "") {
                HideFormError(htmlElement);
            }
            else if (inputValue.length < 8) {
                ShowFormError(htmlElement, "Za krótkie hasło.");
            }
            else if (inputValue.length > 20) {
                ShowFormError(htmlElement, "Za długie hasło.");
            }
            else if (!passwordRegex.test(inputValue)) {
                ShowFormError(htmlElement, "Niepoprawne hasło.");
            }
            else {
                CheckValidForm();
                HideFormError(htmlElement);
            }
        },
        'change': function() {
            var htmlElement = $("#password-form");
            var htmlRepeatElement = $("#password-repeat-form");
            
            var passwordInput = $("#password-form").children("input").val();
            var passwordRepeatInput = $("#password-repeat-form").children("input").val();
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_-])[A-Za-z\d@$!%*?&_-]{8,20}$/;

            if (passwordInput != "" && passwordRegex.test(passwordRepeatInput) && passwordInput != passwordRepeatInput) {
                ShowFormError(htmlElement, 'Hasła nie są identyczne');
                ShowFormError(htmlRepeatElement, 'Hasła nie są identyczne');
            }
            else if (passwordRegex.test(passwordRepeatInput)) {
                HideFormError(htmlElement);
                HideFormError(htmlRepeatElement);
            }
        }
    });
});

function ShowFormError(getElement, ErrorContent) {
    getElement.children(".js-error-message").text(ErrorContent);
    getElement.children(".warning-icon").css("display", "inline");
    
}


function HideFormError(getElement) {
    getElement.children(".js-error-message").text("");
    getElement.children(".warning-icon").css("display", "none");
    
}

function CheckValidForm() {
    // if ()
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
            grecaptcha.reset($(".g-recaptcha")[0]);
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