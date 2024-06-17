let currentSituacija = 1;
let brojac = 0;

// Function to fetch and display a specific situation
async function dohvatiSituaciju(brojSituacije) {
    const response = await fetch(`https://rp2.studenti.math.hr/~zbujanov/dz4/var.php?situacija=${brojSituacije}`);
    const data = await response.json();
    
    if (data.error) {
        document.getElementById('situacija-info').innerHTML = `<p>Error: ${data.error}</p>`;
        document.getElementById('glasanje').style.display = 'none';
    } else {
        prikaziSituaciju(data);
        crtajCanvas(data);
        document.getElementById('glasanje').style.display = 'block';
    }
}

// Function to display the situation details
function prikaziSituaciju(situacija) {
    const infoDiv = document.getElementById('situacija-info');
    
    // Access the first element of the igraci array in tim1
    const prviIgracTim1 = situacija.tim1.igraci[0];
    
    infoDiv.innerHTML = `
        <h2>Tip situacije: ${situacija.tip_situacije}</h2>
        <p>Tim 1: ${situacija.tim1.ime} (${situacija.tim1.boja})</p>
        <p>Tim 2: ${situacija.tim2.ime} (${situacija.tim2.boja})</p>
        <p>Broj glasova DA: ${situacija.broj_glasova[0]}</p>
        <p>Broj glasova NE: ${situacija.broj_glasova[1]}</p>
        <p>Prvi igrač Tim 1: x = ${prviIgracTim1.x}, y = ${prviIgracTim1.y}</p>
    `;

    
}

// Function to handle voting
async function glasaj(glas) {
    const brojSituacije = currentSituacija;
    const response = await fetch(`https://rp2.studenti.math.hr/~zbujanov/dz4/var.php?situacija=${brojSituacije}&glas=${glas}`);
    const data = await response.json();
    
    if (data.error) {
        document.getElementById('situacija-info').innerHTML = `<p>Error: ${data.error}</p>`;
        document.getElementById('glasanje').style.display = 'none';
    } else {
        prikaziSituaciju(data);
    }
}

// Function to load the previous situation
function previousSituacija() {
    if (currentSituacija > 1) {
        currentSituacija--;
        updateSituacijaNumber();
        dohvatiSituaciju(currentSituacija);
    }
}

// Function to load the next situation
function nextSituacija() {
    currentSituacija++;
    updateSituacijaNumber();
    dohvatiSituaciju(currentSituacija);
}

// Function to update the displayed situation number
function updateSituacijaNumber() {
    document.getElementById('situacija-broj').innerText = `Situacija ${currentSituacija}`;
}

// Load the first situation on page load
window.onload = () => {
    dohvatiSituaciju(1);
};
