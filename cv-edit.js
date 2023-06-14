let addExp = document.querySelector("#addExperience");
let addEdu = document.querySelector("#addEducation");
let addLan = document.querySelector("#addLanguage");
let addSkill = document.querySelector("#addSkill");
let addInt = document.querySelector("#addInterest");
let fileInp = document.querySelector("#file");
let fileLbl = document.querySelector("#fileLbl");

let delExp, delEdu, delLan, delSkill, delInt;

fileInp.addEventListener("change", function(){
    fileLbl.innerHTML = "Wybrano plik: " + fileInp.files[0].name;
});


window.addEventListener("load", function() {
    i = document.querySelector("#experienceList").childElementCount; 
    j = document.querySelector("#educationList").childElementCount; 
    k = document.querySelector("#languageList").childElementCount; 
    l = document.querySelector("#skillList").childElementCount; 
    m = document.querySelector("#interestList").childElementCount;
});

delExp = document.querySelectorAll(".delExp");
    delExp.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#exp" + element.id.slice(-1)).remove();
        });
        
    });

let i = 0;
addExp.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#experienceList").innerHTML += `<li id="exp${i}"><input placeholder='Doświadczenie' maxlength="100" type='text' name='experience[name][${i}]'> (<input type='date' name='experience[dateFrom][${i}]' > do <input type='date' class='dateToClass' name='experience[dateTo][${i}]'> <label for='experience[dateTo][${i}]'>teraz <input type='checkbox' class='data-now' name='experience[dateTo][${i}]'></label>)<i class="fa-solid fa-trash fa-xl delExp" id="delExp${i}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
    $(".data-now").off('click');
    $(".data-now").click(function() {
        if (this.checked) {
            $(this).parent().siblings(".dateToClass").attr("disabled", "disabled");
        }
        else {
            $(this).parent().siblings(".dateToClass").removeAttr("disabled");
        }
    });
    i++;
    delExp = document.querySelectorAll(".delExp");
    delExp.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#exp" + element.id.slice(-1)).remove();
        });
        
    });
});

delEdu = document.querySelectorAll(".delEdu");
    delEdu.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#edu" + element.id.slice(-1)).remove();
        });
        
    });

let j = 0;
addEdu.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#educationList").innerHTML += `<li id="edu${j}"><input placeholder='Edukacja' maxlength="100" type='text' name='education[name][${j}]'> (<input type='date' name='education[dateFrom][${j}]' > do <input type='date' name='education[dateTo][${j}]' class='dateToClass'> <label for='education[dateTo][${j}]'>teraz <input type='checkbox' class='data-now' name='education[dateTo][${j}]'></label>)<i class="fa-solid fa-trash fa-xl delEdu" id="delEdu${j}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
    $(".data-now").off('click');
    $(".data-now").click(function() {
        if (this.checked) {
            $(this).parent().siblings(".dateToClass").attr("disabled", "disabled");
        }
        else {
            $(this).parent().siblings(".dateToClass").removeAttr("disabled");
        }
    });
    j++;
    delEdu = document.querySelectorAll(".delEdu");
    delEdu.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#edu" + element.id.slice(-1)).remove();
        });
        
    });
});

delLan = document.querySelectorAll(".delLan");
    delLan.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#lan" + element.id.slice(-1)).remove();
        });
        
    });

let k = 0;
addLan.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#languageList").innerHTML += `<li id="lan${k}"><input placeholder='Język' maxlength="50" type='text' name='language[name][${k}]'> (<input placeholder='Poziom' maxlength="20" type='text' name='language[level][${k}]'>)<i class="fa-solid fa-trash fa-xl delLan" id="delLan${k}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
    k++;
    delLan = document.querySelectorAll(".delLan");
    delLan.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#lan" + element.id.slice(-1)).remove();
        });
        
    });
});

delSkill = document.querySelectorAll(".delSkill");
    delSkill.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#skill" + element.id.slice(-1)).remove();
        });
        
    });

let l = 0;
addSkill.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#skillList").innerHTML += `<li id="skill${l}"><input placeholder='Umiejętność' maxlength="50" type='text' name='skill[${l}]'><i class="fa-solid fa-trash fa-xl delSkill" id="delSkill${i}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
    l++;
    delSkill = document.querySelectorAll(".delSkill");
    delSkill.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#skill" + element.id.slice(-1)).remove();
        });
        
    });
});

delInt = document.querySelectorAll(".delInt");
delInt.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#int" + element.id.slice(-1)).remove();
        });
        
    });

let m = 0;
addInt.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#interestList").innerHTML += `<li id="int${m}"><input placeholder='Zainteresowanie' maxlength="50" type='text' name='interest[${m}]'><i class="fa-solid fa-trash fa-xl delInt" id="delInt${m}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
    m++;
    delInt = document.querySelectorAll(".delInt");
    delInt.forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#int" + element.id.slice(-1)).remove();
        });
        
    });
});

$(document).ready(function() {
    $(".data-now").click(function() {
        if (this.checked) {
            $(this).parent().siblings(".dateToClass").attr("disabled", "disabled");
        }
        else {
            $(this).parent().siblings(".dateToClass").removeAttr("disabled");
        }
    });

    var photoChange = false;

    $("#cv-form").on("submit", function(e) {
        e.preventDefault();
        var dataToSend = new FormData(this);
        dataToSend.set("nationality", $("#country").countrySelect("getSelectedCountryData").iso2);
        if (iti.isValidNumber()) {
            dataToSend.set("phoneNumber", iti.getNumber());
        }
        dataToSend.set("photo_changed", photoChange);
        // if ($('#file').val() == "" && $('.cv-photo').children("img").attr("src") != undefined) {
        //     var oldFilePath = $('.cv-photo').children("img").attr("src");
        //     dataToSend.set("photo_name", oldFilePath.substr(oldFilePath.lastIndexOf('/') + 1));
        // }
        $.ajax({
            type: "POST",
            url: 'server/change-user-cv.php',
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
                    $(errorBack).css("opacity", 1)
                    $(errorBack).css("z-index", 200)
                    return;
                }
    
                if (result.success) {
                    finishCV(result.accountID);
                    $("#error").text();
                }
                else {
                    if (result.error.message == undefined) {
                        $("#error").text("Wystąpił nieoczekiwany błąd po stronie serwera.<br> Proszę spróbować jeszcze raz.");
                        $(errorBack).css("opacity", 1)
                        $(errorBack).css("z-index", 200)
                        return;
                    }
                    $("#error-message").text(result.error.message);
                }
            }
        });
    });

    function finishCV() {
        $(location).attr('href',`employee-mainpage.php`);
    }

    $('#file').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg")) 
        {
            var reader = new FileReader();
            reader.onload = function(e) { 
                $('.cv-photo').children("img").attr('src', e.target.result);
                photoChange = true;
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
});