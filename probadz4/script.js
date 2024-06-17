let currentSituacija = 1;
let odluka = "NE"; // Default decision
let selectedPlayer = null; // Store the currently selected player
let currentLine = null; // Store the current line position

// Function to fetch and display a specific situation
function dohvatiSituaciju(brojSituacije) {
    $.ajax({
        url: `https://rp2.studenti.math.hr/~zbujanov/dz4/var.php?situacija=${brojSituacije}`,
        method: 'GET',
        success: function(data) {
            if (data.error) {
                console.error(`Error fetching situation ${brojSituacije}: ${data.error}`);
            } else {
                prikaziSituaciju(data);
                $('#glasanje').show();
                currentSituacija = brojSituacije;
                updateSituacijaNumber();
                window.currentSituacijaData = data; // Store the current situation data
                selectedPlayer = null; // Reset selected player
                currentLine = null; // Reset current line
                updateVotingButtons(null); // Reset voting buttons to show "NE"
            }
        },
        error: function(error) {
            console.error('Error fetching the situation:', error);
        }
    });
}

// Function to display the situation details
function prikaziSituaciju(situacija) {
    const infoDiv = $('#situacija-info');
    
    const prviIgracTim1 = situacija.tim1.igraci[0];
    
    infoDiv.html(`
        <h2>Provjera je li ${situacija.tim1.ime} dala ${situacija.tip_situacije}.</h2>
        <div style="display: flex; align-items: center;">
        Utakmica:
        <div style="width: 20px; height: 20px; background-color: ${situacija.tim1.boja}; margin-right: 5px; border: solid 1px;"></div>
        ${situacija.tim1.ime} - ${situacija.tim2.ime}
        <div style="width: 20px; height: 20px; background-color: ${situacija.tim2.boja}; margin-right: 5px; border: solid 1px;"></div>
        </div>

        <p>Do sada: ${situacija.broj_glasova[0]} gledatelja kaže DA, ${situacija.broj_glasova[1]} gledatelja kaže NE.</p>
        <p>Prvi igrač Tim 1: x = ${prviIgracTim1.x}, y = ${prviIgracTim1.y}</p>
    `);

    crtajCanvas(situacija, currentLine);
}

// Function to handle voting
function glasaj(glas) {
    $.ajax({
        url: `https://rp2.studenti.math.hr/~zbujanov/dz4/var.php?situacija=${currentSituacija}&glas=${glas}`,
        method: 'GET',
        success: function(data) {
            if (data.error) {
                console.error(`Error voting on situation ${currentSituacija}: ${data.error}`);
            } else {
                prikaziSituaciju(data);
            }
        },
        error: function(error) {
            console.error('Error voting on the situation:', error);
        }
    });
}

// Function to load the previous situation
function previousSituacija() {
    if (currentSituacija > 1) {
        dohvatiSituaciju(currentSituacija - 1);
    }
}

// Function to load the next situation
function nextSituacija() {
    dohvatiSituaciju(currentSituacija + 1);
}

// Function to update the displayed situation number
function updateSituacijaNumber() {
    $('#situacija-broj').text(`Situacija ${currentSituacija}`);
}

// Function to update voting buttons visibility
function updateVotingButtons(player) {
    if (!player) {
        $('#glasaj-da').hide();
        $('#glasaj-ne').show(); // Always show "NE" button when no player is selected
    } else {
        if (window.currentSituacijaData.tim1.igraci.includes(player)) {
            $('#glasaj-da').hide();
            $('#glasaj-ne').show();
        } else if (window.currentSituacijaData.tim2.igraci.includes(player)) {
            $('#glasaj-da').show();
            $('#glasaj-ne').hide();
        }
    }
}

// Function to handle click events on the canvas
function handleCanvasClick(event) {
    const canvas = document.getElementById("canvas");
    const rect = canvas.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    const situacija = window.currentSituacijaData;

    // Reset the decision to default
    odluka = "NE";
    selectedPlayer = null;

    // Determine the clicked player
    const allPlayers = [...situacija.tim1.igraci, ...situacija.tim2.igraci];
    for (const player of allPlayers) {
        if (Math.abs(player.x + 15 - x) <= 10 && Math.abs(player.y + 15 - y) <= 10) {
            selectedPlayer = player;
            break;
        }
    }

    if (selectedPlayer) {
        // Update decision based on the click location
        if (situacija.tip_situacije === 'offside') {
            if (situacija.tim1.igraci.includes(selectedPlayer)) {
                odluka = "NE"; // Player from team 1, not offside
            } else if (situacija.tim2.igraci.includes(selectedPlayer)) {
                odluka = "DA"; // Player from team 2, offside
            }
        }

        // Draw the horizontal line through the clicked player only for offside
        if (situacija.tip_situacije === 'offside') {
            if (currentLine === null || currentLine !== selectedPlayer.y) {
                currentLine = selectedPlayer.y;
            } else {
                // If the same player is clicked again, remove the line
                currentLine = null;
            }
        }

        // Update voting buttons visibility
        updateVotingButtons(selectedPlayer);
    } else {
        // Clicked on the field, not on a player
        if (currentLine !== null) {
            currentLine = null;
        }

        // Show "NE" button by default when no player is selected
        updateVotingButtons(null);
    }

    // Redraw the canvas with the updated line
    crtajCanvas(situacija, currentLine);

    console.log(`Odluka: ${odluka}`);
}

// Load the first situation on page load
$(document).ready(function() {
    dohvatiSituaciju(1);

    $('#previous-btn').on('click', previousSituacija);
    $('#next-btn').on('click', nextSituacija);
    $('#glasaj-da').on('click', function() { glasaj('DA'); });
    $('#glasaj-ne').on('click', function() { glasaj('NE'); });

    // Handle canvas click
    $('#canvas').on('click', handleCanvasClick);
});
