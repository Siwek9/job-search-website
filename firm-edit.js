let fileInp = document.querySelector("#file");
let fileLbl = document.querySelector("#fileLbl");

fileInp.addEventListener("change", function(){
    fileLbl.innerHTML = "Wybrano plik: " + fileInp.files[0].name;
});