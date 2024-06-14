// crtanje canvasa
function initializeCanvas() {
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    return context;
}

// crtanje pozadine
function drawBackground(context) {
    context.fillStyle = "green";
    context.fillRect(0, 0, context.canvas.width, context.canvas.height);
}

// crtanje pravokutnika
function drawRectangles(context) {
    context.strokeStyle = "white";
    context.strokeRect(25, 25, 500, 350);
    context.strokeRect(225, 25, 100, 50);
    context.strokeRect(170, 25, 210, 115);
}

// crtanje gola
function drawGoal(context){
    context.strokeStyle = "black";
    context.strokeRect(235, 25, 80, 2);
}

// crtanje arca
function drawArc(context) {
    const x = 275; 
    const y = 80;
    const radius = 85;
    const startAngle = -Math.PI-Math.PI/4;
    const endAngle = Math.PI/4;
    const counterclockwise = true;

    context.beginPath();
    context.arc(x, y, radius, startAngle, endAngle, counterclockwise);
    context.stroke();
}

// crtanje igrača
function drawPlayers(context, team) {
    context.fillStyle = team.boja; // Set the fill style to the team's jersey color

    team.igraci.forEach(player => {
        context.fillRect(player.x - 10, player.y - 10, 15, 15); // Draw a square for each player
    });
}

// Function to draw the ball path and ball as a white circle
function drawBallPath(context, situacija) {
    const [start, end] = situacija.lopta;

    // Draw the ball path
    if (situacija.tip_situacije === 'gol') {
        context.strokeStyle = "white"; // Color for the ball path
        context.lineWidth = 2; // Width of the line

        context.beginPath();
        context.moveTo(end.x, end.y); // Ending point of the line (ball's final position)
        context.lineTo(start.x, start.y); // Starting point of the line (ball's initial position)
        context.stroke(); // Draw the line

        // Draw the ball at the ending position
        context.fillStyle = "white";
        context.beginPath();
        context.arc(end.x, end.y, 8, 0, 2 * Math.PI); // Draw the circle
        context.fill(); // Fill the circle
    } else {
        // Draw the ball path normally (if needed for other types)
        context.strokeStyle = "white"; // Color for the ball path
        context.lineWidth = 2; // Width of the line

        context.beginPath();
        context.moveTo(start.x, start.y); // Starting point of the line
        context.lineTo(end.x, end.y); // Ending point of the line
        context.stroke(); // Draw the line

        // Draw the starting point of the ball
        context.fillStyle = "white";
        context.beginPath();
        context.arc(start.x, start.y, 8, 0, 2 * Math.PI); // Draw the circle
        context.fill(); // Fill the circle
    }
}