let granim = new Granim({
    element: "#canvas-image-blending",
    direction: "top-bottom",
    isPauseWhenNotInView: true,
    image: {
        source: "http://blogdevcommunity.test/public/images/main_img.jpg",
        blendingMode: "multiply",
        stretchMode: ["stretch", "stretch-if-bigger"]
    },
    states: {
        "default-state": {
            gradients: [
                ["#0F2027", "#8E9EAB"]
                // ["#e35d5b", "#f0cb35"],
                // ["#0F2027", "#8E9EAB"]
            ],
            transitionSpeed: 2000,
            loop: false
        },
        "evening-state": {
            gradients: [
                // ["#DAE2F8", "#DAE2F8"]
                ["#e35d5b", "#f0cb35"]
                // ["#0F2027", "#8E9EAB"]
            ],
            transitionSpeed: 2000,
            loop: false
        },
        "morning-state": {
            gradients: [
                // ["#DAE2F8", "#DAE2F8"]
                // ["#e35d5b", "#f0cb35"]
                ["#DAE2F8", "#DAE2F8"]
            ],
            transitionSpeed: 2000,
            loop: false
        }
    }
});

const heading = document.querySelector(".container h1");
const night   = document.getElementById("night");
const evening = document.getElementById("evening");
const morning = document.getElementById("morning");

night.addEventListener("click", function(event){

    granim.changeState("default-state");
    heading.innerHTML = "Night";

});

evening.addEventListener("click", function(event){

    granim.changeState("evening-state");
    heading.innerHTML = "Evening";

});

morning.addEventListener("click", function(event){

    granim.changeState("morning-state");
    heading.innerHTML = "Morning";

});