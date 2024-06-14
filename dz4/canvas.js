// Variable to keep track of the current line
let currentLine = null;

// Initialize canvas and draw elements
const context = initializeCanvas();
const currentSituation = situacija[0]; // Assume you are dealing with the first situation

drawBackground(context);
drawRectangles(context);
drawArc(context);
drawGoal(context);
drawPlayers(context, currentSituation.tim1);
drawPlayers(context, currentSituation.tim2);
drawBallPath(context, currentSituation);

// Set team names
setTeamNames(currentSituation);

// Add click event listener if the situation type is 'offside'
if (currentSituation.tip_situacije === 'offside') {
    context.canvas.addEventListener('click', (event) => handleCanvasClick(event, context, currentSituation));
}
