let addExp = document.querySelector("#addExperience");
let addEdu = document.querySelector("#addEducation");
let addLan = document.querySelector("#addLanguage");
let addSkill = document.querySelector("#addSkill");
let addInt = document.querySelector("#addInterest");

window.addEventListener("load", function() {
    i = document.querySelector("#experienceList").childElementCount; 
    j = document.querySelector("#educationList").childElementCount; 
    k = document.querySelector("#languageList").childElementCount; 
    l = document.querySelector("#skillList").childElementCount; 
    m = document.querySelector("#interestList").childElementCount;
    // console.log(i);
});

let i = 0;
addExp.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#experienceList").innerHTML += "<li><input placeholder='Doświadczenie' type='text' name='exp[" + i + "]'> (<input type='date' name='expDateFrom[" + i + "]' > do <input type='date' class='dateToClass' name='expDateTo[" + i + "]'> <label for='expDateToNow[" + i + "]'>teraz <input type='checkbox' class='data-now' name='expDateToNow[" + i + "]'></label>)</li>";
    $(".data-now").off('click');
    $(".data-now").click(function() {
        console.log('clikc')
        if (this.checked) {
            $(this).parent().siblings(".dateToClass").attr("disabled", "disabled");
        }
        else {
            $(this).parent().siblings(".dateToClass").removeAttr("disabled");
        }
    });
    i++;
});

let j = 0;
addEdu.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#educationList").innerHTML += "<li><input placeholder='Edukacja' type='text' name='edu" + j + "'> (<input type='date' name='eduDateFrom" + j + "' > do <input type='date' name='eduDateTo" + j + "' class='expDateToClass'>)</li>";
    j++;
});

let k = 0;
addLan.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#languageList").innerHTML += "<li><input placeholder='Język' type='text' name='lan" + k + "'> (<input placeholder='Poziom' type='text' name='lanLevel" + k + "' >)</li>";
    k++;
});

let l = 0;
addSkill.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#skillList").innerHTML += "<li><input placeholder='Umiejętność' type='text' name='skill" + l + "'></li>";
    l++;
});

let m = 0;
addInt.addEventListener("click", function(e){
    e.preventDefault();
    document.querySelector("#interestList").innerHTML += "<li><input placeholder='Zainteresowanie' type='text' name='interest" + m + "'></li>";
    m++;
});

$(document).ready(function() {
    $(".data-now").click(function() {
        console.log('clikc')
        if (this.checked) {
            $(this).parent().siblings(".dateToClass").attr("disabled", "disabled");
        }
        else {
            $(this).parent().siblings(".dateToClass").removeAttr("disabled");
        }
    });
});