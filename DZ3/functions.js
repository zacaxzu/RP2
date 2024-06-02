function crtajPonudeneBoje(colors) {
    const paletaBoja = document.getElementById('paletaBoja');
    paletaBoja.innerHTML = '';

    const colorOptionsContainer = document.createElement('div');
    colorOptionsContainer.classList.add('color-options-container');

    colors.forEach((color, index) => {
        const colorOption = document.createElement('input');
        colorOption.type = 'radio';
        colorOption.id = `color${index}`;
        colorOption.name = 'color';
        colorOption.value = color;

        const label = document.createElement('label');
        label.htmlFor = `color${index}`;
        label.style.backgroundColor = color;

        const colorDiv = document.createElement('div');
        colorDiv.classList.add('color-option');
        colorDiv.appendChild(colorOption);
        colorDiv.appendChild(label);

        colorOptionsContainer.appendChild(colorDiv);
    });

    paletaBoja.appendChild(colorOptionsContainer);

    // Radio button nije kliknut
    const radioButtons = paletaBoja.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(button => {
        button.checked = false;
    });
}

function crvenaSlova(elementPloce, gornjiLijeviRed, gornjiLijeviStupac, donjiDesniRed, donjiDesniStupac, color) {
    const velicinaPravokutnika = (donjiDesniRed - gornjiLijeviRed + 1) * (donjiDesniStupac - gornjiLijeviStupac + 1);

    for (let i = gornjiLijeviRed; i <= donjiDesniRed; i++) {
        for (let j = gornjiLijeviStupac; j <= donjiDesniStupac; j++) {
            const cell = elementPloce.rows[i].cells[j];
            if (cell.textContent && parseInt(cell.textContent) === velicinaPravokutnika) {
                cell.style.color = 'red'; 
            }
        }
    }
}

function dodajRubovePravokutnicima(elementPloce, gornjiLijeviRed, gornjiLijeviStupac, donjiDesniRed, donjiDesniStupac, bojaRuba) {
    // Gornji rub
    for (let j = gornjiLijeviStupac; j <= donjiDesniStupac; j++) {
        const cell = elementPloce.rows[gornjiLijeviRed].cells[j];
        cell.style.borderTop = `2px solid ${bojaRuba}`;
    }

    // Donji rub
    for (let j = gornjiLijeviStupac; j <= donjiDesniStupac; j++) {
        const cell = elementPloce.rows[donjiDesniRed].cells[j];
        cell.style.borderBottom = `2px solid ${bojaRuba}`;
    }

    // Lijevi rub
    for (let i = gornjiLijeviRed; i <= donjiDesniRed; i++) {
        const cell = elementPloce.rows[i].cells[gornjiLijeviStupac];
        cell.style.borderLeft = `2px solid ${bojaRuba}`;
    }

    // Desni rub
    for (let i = gornjiLijeviRed; i <= donjiDesniRed; i++) {
        const cell = elementPloce.rows[i].cells[donjiDesniStupac];
        cell.style.borderRight = `2px solid ${bojaRuba}`;
    }
}

function brisanjeBorderaPravokutnika(elementPloce, gornjiLijeviRed, gornjiLijeviStupac, donjiDesniRed, donjiDesniStupac) {
    // Gornji rub
    for (let j = gornjiLijeviStupac; j <= donjiDesniStupac; j++) {
        const cell = elementPloce.rows[gornjiLijeviRed].cells[j];
        cell.style.borderTop = '';
    }

    // Donji rub
    for (let j = gornjiLijeviStupac; j <= donjiDesniStupac; j++) {
        const cell = elementPloce.rows[donjiDesniRed].cells[j];
        cell.style.borderBottom = '';
    }

    // Lijevi stupac
    for (let i = gornjiLijeviRed; i <= donjiDesniRed; i++) {
        const cell = elementPloce.rows[i].cells[gornjiLijeviStupac];
        cell.style.borderLeft = '';
    }

    // Desni stupac
    for (let i = gornjiLijeviRed; i <= donjiDesniRed; i++) {
        const cell = elementPloce.rows[i].cells[donjiDesniStupac];
        cell.style.borderRight = '';
    }
}

export { crtajPonudeneBoje };   
export { brisanjeBorderaPravokutnika };
export { dodajRubovePravokutnicima };
export { crvenaSlova };