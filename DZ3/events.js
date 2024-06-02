import { crtajPonudeneBoje, brisanjeBorderaPravokutnika, dodajRubovePravokutnicima, crvenaSlova } from './functions.js';

let odabranaBoja = ''; 
let Ploca = []; 
let prviKlik = null;
const iskoristeneBoje = new Set(); 

document.addEventListener('DOMContentLoaded', () => {
    const odabranaPloca = document.getElementById('odabranaPloca');
    const startGameButton = document.getElementById('igra-btn');
    const elementPloce = document.getElementById('Ploca');
    const paletaBoja = document.getElementById('paletaBoja');

    // Učitavanje igre
    if (typeof game !== 'undefined' && game.length > 0) {
        // Dropdown
        game.forEach((gameItem, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = gameItem.name;
            odabranaPloca.appendChild(option);
        });

        // Reset igre kada je započeta nova igra
        startGameButton.addEventListener('click', () => {
            const odabranaPlocaIndex = odabranaPloca.value;
            iskoristeneBoje.clear();
            crtajPlocu(game[odabranaPlocaIndex]);
            crtajPonudeneBoje(game[odabranaPlocaIndex].color);
            odabranaBoja = '';
        });
    } 
    else {
        console.error('Game data not found or is empty.');
    }

    paletaBoja.addEventListener('change', (event) => {
        odabranaBoja = event.target.value;
        // Provjera jel odabrana boja već iskorištena
        if (iskoristeneBoje.has(odabranaBoja)) {
            event.target.checked = false;
            odabranaBoja = '';
        }
    });

    elementPloce.addEventListener('click', (event) => {
    const cell = event.target;
    if (!cell.classList.contains('cell')) return; 

    // Provjera jel boja već odabrana
    if (odabranaBoja === '') {
        return;
    }

    if (iskoristeneBoje.has(odabranaBoja)) {
        return;
    }

    const red = cell.parentNode.rowIndex;
    const stupac = cell.cellIndex;

    if (!prviKlik) {
        prviKlik = cell;
        cell.classList.add('selected');
    } else {
        const gornjiLijeviRed = prviKlik.parentNode.rowIndex;
        const gornjiLijeviStupac = prviKlik.cellIndex;

        const donjiDesniRed = red;
        const donjiDesniStupac = stupac;

        // Drugi klik
        if (red >= gornjiLijeviRed && stupac >= gornjiLijeviStupac) {
            // Provjera jesu li unutarnje ćelije već obojane
            let obojenaCelija = false;
            for (let i = gornjiLijeviRed; i <= red; i++) {
                for (let j = gornjiLijeviStupac; j <= stupac; j++) {
                    if (Ploca[i][j] && Ploca[i][j] !== odabranaBoja) {
                        obojenaCelija = true;
                        break;
                    }
                }
                if (obojenaCelija) break;
            }

            // Ukoliko su celije unutar odabranog pravokutnika već obojane drugom bojom
            if (obojenaCelija) {
                prviKlik.classList.remove('selected');
                prviKlik = null;
                return;
            }

            // Postavite rubove pravokutnika
            dodajRubovePravokutnicima(elementPloce, gornjiLijeviRed, gornjiLijeviStupac, donjiDesniRed, donjiDesniStupac, 'black');

            // Bojanje pravokutnika odabranom bojom
            for (let i = gornjiLijeviRed; i <= red; i++) {
                for (let j = gornjiLijeviStupac; j <= stupac; j++) {
                    Ploca[i][j] = odabranaBoja;
                    const targetCell = elementPloce.rows[i].cells[j];
                    targetCell.style.backgroundColor = odabranaBoja;
                }
            }

            // Mijenjanje broja u crveno ako je jednake površine kao pravokutnik
            crvenaSlova(elementPloce, gornjiLijeviRed, gornjiLijeviStupac, donjiDesniRed, donjiDesniStupac, 'red');

            // Označi boju kao iskorištenu
            iskoristeneBoje.add(odabranaBoja);

            // Provjera jel ploča popunjena
            if (povrsinaPoplocanogPodrucja() === Ploca.length * Ploca.length) {
                alert('Čestitamo! Uspješno ste riješili Shikaku!');
            }
        } 

        prviKlik.classList.remove('selected');
        prviKlik = null;
    }
});

    // Event za brisanje
    elementPloce.addEventListener('contextmenu', (event) => {
        event.preventDefault();
        const cell = event.target;
        if (!cell.classList.contains('cell')) return; // Ignoriranje klikova koji nisu na celije

        const red = cell.parentNode.rowIndex;
        const stupac = cell.cellIndex;
        const bojaZaBrisanje = Ploca[red][stupac];

        // Ukoliko celija nije obojana
        if (!bojaZaBrisanje) {
            return;
        }

        // Trazenje granica za brisanje
        let topLeftRow = red, topLeftCol = stupac, bottomRightRow = red, bottomRightCol = stupac;
        for (let i = 0; i < Ploca.length; i++) {
            for (let j = 0; j < Ploca[i].length; j++) {
                if (Ploca[i][j] === bojaZaBrisanje) {
                    if (i < topLeftRow) topLeftRow = i;
                    if (j < topLeftCol) topLeftCol = j;
                    if (i > bottomRightRow) bottomRightRow = i;
                    if (j > bottomRightCol) bottomRightCol = j;
                }
            }
        }

        // Brisanje boje u pravokutniku
        for (let i = topLeftRow; i <= bottomRightRow; i++) {
            for (let j = topLeftCol; j <= bottomRightCol; j++) {
                if (Ploca[i][j] === bojaZaBrisanje) {
                    Ploca[i][j] = '';
                    const targetCell = elementPloce.rows[i].cells[j];
                    targetCell.style.backgroundColor = '';
                    targetCell.style.color = ''; 
                }
            }
        }

        brisanjeBorderaPravokutnika(elementPloce, topLeftRow, topLeftCol, bottomRightRow, bottomRightCol);

        // Oznaci boju kao neiskoristenu
        iskoristeneBoje.delete(bojaZaBrisanje);
    });
});

function crtajPlocu(OdabranaPloca) {
    const velicinaPloce = OdabranaPloca.size;
    Ploca = Array.from({ length: velicinaPloce }, () => Array(velicinaPloce).fill(''));

    const tableBody = document.createElement('tbody');

    for (let i = 0; i < velicinaPloce; i++) {
        const red = document.createElement('tr');
        for (let j = 0; j < velicinaPloce; j++) {
            const cell = document.createElement('td');
            cell.classList.add('cell');
            red.appendChild(cell);

            // Postavljaju se brojevi iz zadane igre
            const index = OdabranaPloca.row.findIndex((r, idx) => r === i + 1 && OdabranaPloca.col[idx] === j + 1);
            if (index !== -1) {
                cell.textContent = OdabranaPloca.num[index];
            }
        }
        tableBody.appendChild(red);
    }

    const elementPloce = document.getElementById('Ploca');
    elementPloce.innerHTML = '';
    elementPloce.appendChild(tableBody);
}

function povrsinaPoplocanogPodrucja() {
    let obojanoPodrucje = 0;
    for (let i = 0; i < Ploca.length; i++) {
        for (let j = 0; j < Ploca[i].length; j++) {
            if (Ploca[i][j]) {
                obojanoPodrucje++;
            }
        }
    }
    return obojanoPodrucje;
}