let addEdu = document.querySelector("#addEducation");
let addSkill = document.querySelector("#addSkill");
let fileInp = document.querySelector("#file");
let fileLbl = document.querySelector("#fileLbl");

fileInp.addEventListener("change", function(){
    fileLbl.innerHTML = "Wybrano plik: " + fileInp.files[0].name;
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
    document.querySelector("#educationList").innerHTML += `<li id="edu${i}"><input placeholder='Edukacja' maxlength="100" type='text' name='education[name][${j}]'><i class="fa-solid fa-trash fa-xl delEdu" id="delEdu${i}" style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>`;
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
