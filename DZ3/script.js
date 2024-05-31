document.addEventListener('DOMContentLoaded', () => {
    const gameSelect = document.getElementById('gameSelect');
    const startGameButton = document.getElementById('startGameButton');
    const gameGrid = document.getElementById('gameGrid');
    const colorPalette = document.getElementById('colorPalette');

    // Ensure the game data is loaded
    if (typeof game !== 'undefined' && game.length > 0) {
        // Dynamically create dropdown options for each game
        game.forEach((gameItem, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = gameItem.name;
            gameSelect.appendChild(option);
        });

        // Add event listener to handle game start button click
        startGameButton.addEventListener('click', () => {
            const selectedGameIndex = gameSelect.value;
            renderGameGrid(game[selectedGameIndex]);
            renderColorPalette(game[selectedGameIndex].color);
        });

        // Render the initial game grid and color palette
        renderGameGrid(game[0]);
        renderColorPalette(game[0].color);
    } else {
        console.error('Game data not found or is empty.');
    }
});

function renderGameGrid(selectedGame) {
    gameGrid.innerHTML = '';  // Clear existing grid

    const size = selectedGame.size;
    gameGrid.style.gridTemplateColumns = `repeat(${size}, 50px)`;
    gameGrid.style.gridTemplateRows = `repeat(${size}, 50px)`;
    gameGrid.classList.add('grid');

    for (let i = 1; i <= size; i++) {
        for (let j = 1; j <= size; j++) {
            const cell = document.createElement('div');
            cell.classList.add('cell');

            const index = selectedGame.row.findIndex((r, idx) => r === i && selectedGame.col[idx] === j);
            if (index !== -1) {
                cell.textContent = selectedGame.num[index];
                cell.style.backgroundColor = selectedGame.color[index];
            }

            gameGrid.appendChild(cell);
        }
    }
}

function renderColorPalette(colors) {
    colorPalette.innerHTML = '';  // Clear existing color palette

    colors.forEach((color, index) => {
        const colorOption = document.createElement('div');
        colorOption.classList.add('color-option');

        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.id = `color${index}`;
        radio.name = 'color';
        radio.value = color;

        const label = document.createElement('label');
        label.htmlFor = `color${index}`;
        label.style.backgroundColor = color;

        colorOption.appendChild(radio);
        colorOption.appendChild(label);
        colorPalette.appendChild(colorOption);
    });
}
