var counterContainer = null;
var jackpotCountDefault = null;
var jackpotCountCopy = null;

document.addEventListener("DOMContentLoaded", () => {
    counterContainer = document.getElementById("jackpot-count-container");
    jackpotCountDefault = document.getElementById("jackpot-count");
    jackpotCountCopy = document.getElementById("jackpot-count-copy");
    
    const jackpotInterval = setInterval(jackpot,1500)
    
    jackpotCountDefault.addEventListener("animationend", () => {
        jackpotCountDefault.classList.remove("jackpot-old-animation")
    })
    jackpotCountCopy.addEventListener("animationend", () => {
        jackpotCountDefault.innerHTML = jackpotCountCopy.innerHTML
        jackpotCountCopy.classList.remove("jackpot-new-animation")
    })
})

const jackpotChance = 0.75
function jackpot() {
    if (Math.random() > jackpotChance) {return;}
    jackpotCountCopy.innerHTML = Number(jackpotCountDefault.innerHTML) + 1
    
    jackpotCountCopy.classList.add("jackpot-new-animation")
    jackpotCountDefault.classList.add("jackpot-old-animation")

}