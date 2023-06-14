let addEdu = document.querySelector("#addEducation");
let addSkill = document.querySelector("#addSkill");
let fileInp = document.querySelector("#file");
let fileLbl = document.querySelector("#fileLbl");

window.addEventListener("load", function() {
    i = document.querySelector("#educationList").childElementCount; 
    j = document.querySelector("#skillList").childElementCount; 
});

delEdu = document.querySelectorAll(".delEdu");
    delEdu.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#edu" + element.id.slice(-1)).remove();
        });
        
    });

let i = 0;
addEdu.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#educationList").innerHTML += `<li id="edu${i}"><input placeholder='Edukacja' maxlength="100" type='text' name='education[${j}]'><i class="fa-solid fa-trash fa-xl delEdu" id="delEdu${i}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
    i++;
    delEdu = document.querySelectorAll(".delEdu");
    delEdu.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#edu" + element.id.slice(-1)).remove();
        });
        
    });
});

delSkill = document.querySelectorAll(".delSkill");
    delSkill.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#skill" + element.id.slice(-1)).remove();
        });
        
    });

let j = 0;
addSkill.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#skillList").innerHTML += `<li id="skill${j}"><input placeholder='Umiejętność' maxlength="50" type='text' name='skill[${j}]'><i class="fa-solid fa-trash fa-xl delSkill" id="delSkill${j}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
    j++;
    delSkill = document.querySelectorAll(".delSkill");
    delSkill.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#skill" + element.id.slice(-1)).remove();
        });
        
    });
});

document.querySelector("#tryAgain").addEventListener("click", function(e){
    $("#errorBack").css("opacity", 0);
    $("#errorBack").css("z-index", -200);
});

$(document).ready(function() {
    console.log("siema")
    $("#offer-form").on('submit', function(e) {
        console.log("lol");
        e.preventDefault();
        var dataToSend = new FormData(this);
        if (iti.isValidNumber()) {
            dataToSend.set("contactPhone", iti.getNumber());
        }

        if ((new URLSearchParams(window.location.search)).get('offerID') != "") {
            dataToSend.set("offerID", (new URLSearchParams(window.location.search)).get('offerID'));
        }
        $.ajax({
            type: "POST",
            url: 'server/edit-create-offer.php',
            data: dataToSend,
            contentType: false,
            cache: false,
            processData: false,
            success: function(r) {
                var result;
                console.log(r);
                try {
                    var result = JSON.parse(r);
                }
                catch(error) {
                    $("#error").text("Wystąpił nieoczekiwany błąd po stronie serwera.<br> Proszę spróbować jeszcze raz.");
                    $("#errorBack").css("opacity", 1)
                    $("#errorBack").css("z-index", 200)
                    return;
                }
    
                if (result.success) {
                    finishOffer(result.accountID);
                    $("#error").text();
                }
                else {
                    if (result.error.message == undefined) {
                        $("#error").text("Wystąpił nieoczekiwany błąd po stronie serwera.<br> Proszę spróbować jeszcze raz.");
                        $("#errorBack").css("opacity", 1);
                        $("#errorBack").css("z-index", 200);
                        return;
                    }
                    else {
                        $("#error").text(result.error.message);
                        $("#errorBack").css("opacity", 1);
                        $("#errorBack").css("z-index", 200);
                        return;
                    }
                }
            }
        });
    });
    
    function finishOffer() {
        $(location).attr('href',`employer-mainpage.php`);
    }
});