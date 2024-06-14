// Variable to keep track of the current line
let currentLine = null;

// Initialize canvas and draw elements
const context = initializeCanvas();
const currentSituationIndex  = 0; // Assume you are dealing with the first situation

// Event listeners for buttons
document.getElementById("prev-situation").addEventListener("click", () => {
    if (currentSituationIndex > 0) {
        currentSituationIndex--;
        initializeAndDrawCurrentSituation();
    }
});

document.getElementById("next-situation").addEventListener("click", () => {
    if (currentSituationIndex < situacija.length - 1) {
        currentSituationIndex++;
        initializeAndDrawCurrentSituation();
    }
});

// Initialize the first situation
initializeAndDrawCurrentSituation();