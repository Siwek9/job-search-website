let addExp = document.querySelector("#addExperience");
let addEdu = document.querySelector("#addEducation");
let addLan = document.querySelector("#addLanguage");
let addSkill = document.querySelector("#addSkill");
let addInt = document.querySelector("#addInterest");

let i = 0;
addExp.addEventListener("click", function(){
    document.querySelector("#experienceList").innerHTML += "<li><input placeholder=\"Doświadczenie\" type=\"text\" name=\"exp" + i + "\"> (<input type=\"date\" name=\"expDateFrom" + i + "\" > do <input type=\"date\" name=\"expDateTo" + i + "\">)</li>";
    i++;
});

let j = 0;
addEdu.addEventListener("click", function(){
    document.querySelector("#educationList").innerHTML += "<li><input placeholder=\"Edukacja\" type=\"text\" name=\"edu" + j + "\"> (<input type=\"date\" name=\"eduDateFrom" + j + "\" > do <input type=\"date\" name=\"eduDateTo" + j + "\">)</li>";
    j++;
});

let k = 0;
addLan.addEventListener("click", function(){
    document.querySelector("#languageList").innerHTML += "<li><input placeholder=\"Język\" type=\"text\" name=\"lan" + k + "\"> (<input placeholder=\"Poziom\" type=\"text\" name=\"lanLevel" + k + "\" >)</li>";
    k++;
});

let l = 0;
addSkill.addEventListener("click", function(){
    document.querySelector("#skillList").innerHTML += "<li><input placeholder=\"Umiejętność\" type=\"text\" name=\"skill" + l + "\"></li>";
    l++;
});

let m = 0;
addInt.addEventListener("click", function(){
    document.querySelector("#interestList").innerHTML += "<li><input placeholder=\"Zainteresowanie\" type=\"text\" name=\"interest" + m + "\"></li>";
    m++;
});