// Function to initialize and draw the current situation
function initializeAndDrawCurrentSituation(currentSituationIndex) {
    const context = initializeCanvas();
    const currentSituation = situacija[currentSituationIndex];

    drawBackground(context);
    drawRectangles(context);
    drawArc(context);
    drawGoal(context);
    drawPlayers(context, currentSituation.tim1);
    drawPlayers(context, currentSituation.tim2);
    drawBallPath(context, currentSituation);

    setTeamNames(currentSituation);
    rezultatiGlasanja(currentSituation);
    updateSituationNumber(currentSituationIndex);

    if (currentSituation.tip_situacije === 'offside') {
        context.canvas.addEventListener('click', (event) => handleCanvasClick(event, context, currentSituation));
    }
}

// Initialize canvas and draw elements for a given situation
function initializeCanvas() {
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    return context;
}

// Update the situation number display
function updateSituationNumber(index) {
    const situationNumberElement = document.getElementById("situation-number");
    situationNumberElement.innerText = `Situacija broj: ${index + 1}`;
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

// Function to draw a horizontal line
function drawHorizontalLine(context, y) {
    context.strokeStyle = 'white';
    context.lineWidth = 2;

    context.beginPath();
    context.setLineDash([5, 15]);
    context.moveTo(0, y);
    context.lineTo(context.canvas.width, y);
    context.stroke();

    context.setLineDash([]);
}

// Function to clear the canvas and redraw all elements except the horizontal line
function clearCanvasAndRedraw(context, situation) {
    // Clear the canvas
    context.clearRect(0, 0, context.canvas.width, context.canvas.height);

    // Redraw all elements
    drawBackground(context);
    drawRectangles(context);
    drawArc(context);
    drawGoal(context);
    drawPlayers(context, situation.tim1);
    drawPlayers(context, situation.tim2);
    drawBallPath(context, situation);
}

// Function to handle canvas clicks
function handleCanvasClick(event, context, situation) {
    const rect = context.canvas.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    // Check if the click is on a player
    const allPlayers = [...situation.tim1.igraci, ...situation.tim2.igraci];
    let clickedPlayer = null;
    for (const player of allPlayers) {
        if (x >= player.x - 10 && x <= player.x + 10 && y >= player.y - 10 && y <= player.y + 10) {
            clickedPlayer = player;
            break;
        }
    }

    // If a player was clicked, draw or remove the horizontal line
    if (clickedPlayer) {
        if (currentLine) {
            // If there's already a line, clear the canvas and redraw all elements
            clearCanvasAndRedraw(context, situation);
            currentLine = null;
        } else {
            // Draw the horizontal line through the clicked player
            drawHorizontalLine(context, clickedPlayer.y);
            currentLine = clickedPlayer.y;
        }
    } else {
        // If clicked elsewhere, clear the line if it exists
        if (currentLine) {
            clearCanvasAndRedraw(context, situation);
            currentLine = null;
        }
    }
}

// Set the team names and colors in the header
function setTeamNames(situation) {
    const matchHeader = document.getElementById("match-header");
    let conditionalText = '';
    if(situation.tip_situacije === 'gol'){
        conditionalText = 'Provjera je li ' + situation.tim1.ime + ' dala gol.';
    }
    else {
        conditionalText = 'Provjera je li ' + situation.tim1.ime + ' napravila offside.';
    }

    matchHeader.innerHTML = `
        <div style="display: flex; align-items: center;">
            Utakmica: 
            <div style="width: 20px; height: 20px; background-color: ${situation.tim1.boja}; margin-right: 5px;"></div>
            <span>${situation.tim1.ime}</span>
            <span> - </span>
            <span>${situation.tim2.ime}</span>
            <div style="width: 20px; height: 20px; background-color: ${situation.tim2.boja}; margin-left: 5px;"></div>
        </div>
        <div>${conditionalText}</div>
    `;
}

function rezultatiGlasanja(situation){
    const rezultati_glasanja = document.getElementById("rezultati-glasanja");
    let conditionalText = '';
    let glasoviText = `Do sada: ${situation.broj_glasova[0]} kaže DA, ${situation.broj_glasova[1]} kaže NE.`;

    rezultati_glasanja.innerHTML = `<div style="display: flex; align-items: center;">Do sada: ${situation.broj_glasova[0]} gledatelja kaže DA, ${situation.broj_glasova[1]} gledatelja kaže NE.</div>`;
}

