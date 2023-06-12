$(document).ready(function() {
    $("#button").click(function() {
        console.log((new URLSearchParams(window.location.search)).get('userID'))
        $.ajax({
            type: "POST",
            url: 'send-activation-email.php',
            data: {'userID': (new URLSearchParams(window.location.search)).get('userID')},
            success: function(r) {
                console.log(r);

            }
        });
    });
});