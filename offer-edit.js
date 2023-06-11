let addEdu = document.querySelector("#addEducation");
let addSkill = document.querySelector("#addSkill");

let i = 0;
addEdu.addEventListener("click", function(){
    document.querySelector("#educationList").innerHTML += "<li><input placeholder=\"Edukacia\" type=\"text\" name=\"edu" + i + "\"> (<input type=\"date\" name=\"eduDateFrom" + i + "\" > do <input type=\"date\" name=\"eduDateTo" + i + "\">)</li>";
    i++;
});

let j = 0;
addSkill.addEventListener("click", function(){
    document.querySelector("#skillList").innerHTML += "<li><input placeholder=\"Umiejętność\" type=\"text\" name=\"skill" + j + "\"></li>";
    j++;
});
