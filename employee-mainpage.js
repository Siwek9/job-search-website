// let mainWindow = document.querySelector("#businesses");
let track = document.querySelector("#imageTrack");
let cards = document.querySelectorAll(".image");

window.onmousedown = e => {
    track.dataset.mouseDownAt = e.clientX;
}

window.onmouseup = e => {
    track.dataset.mouseDownAt = "0";
    track.dataset.prevPercentage = track.dataset.percentage
}

window.onmousemove = e => {
    if(track.dataset.mouseDownAt == "0") return;
    const mouseDelta = parseFloat(track.dataset.mouseDownAt) - e.clientX, 
          maxDelta = window.innerWidth/2,
          percentage = (mouseDelta / maxDelta) * -100,
          nextPercentageTemp = parseFloat(track.dataset.prevPercentage) + percentage,
          nextPercentage = Math.max(Math.min(nextPercentageTemp, 0), -100);

    track.dataset.percentage = nextPercentage;

    // track.style.transform = "translate(" + nextPercentage + "%, 20%)";
    track.animate({
        transform: `translate(${nextPercentage}%, 20%)`
    }, {duration: 1200, fill:"forwards"});

    for(const image of track.getElementsByClassName("image")){ //na querySelector nie działa
        // image.style.objectPosition = (nextPercentage + 100) + "50%";
        image.animate({
            objectPosition: `${nextPercentage + 100}% center`
        }, {duration: 1200, fill:"forwards"});

    }
}

// cards.forEach(element=>{
//     element.addEventListener("click", function(){
//         let link = "company-offers-show.php?companyID=" + element.id;
//         window.open(link, "_self").focus();
//     });
// });