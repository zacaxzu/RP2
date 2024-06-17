// Initialize canvas and draw elements for a given situation
function initializeCanvas() {
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    return context;
}

// Draw background
function drawBackground(context) {
    context.fillStyle = "green";
    context.fillRect(0, 0, context.canvas.width, context.canvas.height);
}

// Draw rectangles
function drawRectangles(context) {
    context.strokeStyle = "white";
    context.strokeRect(25, 25, 500, 350);
    context.strokeRect(225, 25, 100, 50);
    context.strokeRect(170, 25, 210, 115);
}

// Draw goal
function drawGoal(context) {
    context.strokeStyle = "black";
    context.strokeRect(235, 25, 80, 2);
}

// Draw arc
function drawArc(context) {
    const x = 275; 
    const y = 80;
    const radius = 85;
    const startAngle = -Math.PI - Math.PI / 4;
    const endAngle = Math.PI / 4;
    const counterclockwise = true;

    context.beginPath();
    context.arc(x, y, radius, startAngle, endAngle, counterclockwise);
    context.stroke();
}

// Draw players
function drawPlayers(context, team) {
    context.fillStyle = team.boja; // Set the fill style to the team's jersey color

    team.igraci.forEach(player => {
        context.fillRect(player.x + 15, player.y + 15, 15, 15); // Draw a square for each player
    });
}

// Draw horizontal line through the selected player
function drawHorizontalLine(context, y) {
    context.strokeStyle = "white";
    context.beginPath();
    context.setLineDash([5, 15]);
    context.moveTo(0, y + 15);
    context.lineTo(context.canvas.width, y + 15);
    context.stroke();
    context.setLineDash([]);
}

// Draw ball path
function drawBallPath(context, situacija) {
    const [start, end] = situacija.lopta;
    const pomakX = 25, pomakY = 25;

    // Draw the ball path
    context.strokeStyle = "white"; // Color for the ball path
    context.lineWidth = 2; // Width of the line

    context.beginPath();
    context.moveTo(start.x + pomakX, start.y + pomakY); // Starting point of the line
    context.lineTo(end.x + pomakX, end.y + pomakY); // Ending point of the line
    context.stroke(); // Draw the line

    // Draw the ball at the ending position
    context.fillStyle = "white";
    context.beginPath();
    context.arc(end.x + pomakX, end.y + pomakY, 8, 0, 2 * Math.PI); // Draw the circle
    context.fill(); // Fill the circle
}

// Main function to draw the canvas
function crtajCanvas(situacija, currentLine) {
    const context = initializeCanvas();

    drawBackground(context);
    drawRectangles(context);
    drawArc(context);
    drawGoal(context);
    drawPlayers(context, situacija.tim1);
    drawPlayers(context, situacija.tim2);
    drawBallPath(context, situacija);

    if (currentLine !== null) {
        drawHorizontalLine(context, currentLine);
    }
}
