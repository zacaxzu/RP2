let selectedColor = ''; // Global variable to store selected color
let gameBoard = []; // Array to store game board data
let firstClickCell = null; // Variable to store the first clicked cell

document.addEventListener('DOMContentLoaded', () => {
    const gameSelect = document.getElementById('gameSelect');
    const startGameButton = document.getElementById('startGameButton');
    const gameBoardElement = document.getElementById('gameBoard');
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
            renderGameBoard(game[selectedGameIndex]);
            renderColorPalette(game[selectedGameIndex].color);
        });

        // Render the initial game board and color palette
        renderGameBoard(game[0]);
        renderColorPalette(game[0].color);
    } else {
        console.error('Game data not found or is empty.');
    }

    // Add event listener to color palette to handle color selection
    colorPalette.addEventListener('change', (event) => {
        selectedColor = event.target.value;
    });

    // Add event listener to game board cells to handle rectangle drawing
    gameBoardElement.addEventListener('click', (event) => {
        const cell = event.target;
        if (!cell.classList.contains('cell')) return; // Ignore clicks on elements other than cells

        const row = cell.parentNode.rowIndex;
        const col = cell.cellIndex;

        if (!firstClickCell) {
            // First click: set top-left corner
            firstClickCell = cell;
            cell.classList.add('selected');
        } else {
            // Second click: set bottom-right corner
            const topLeftRow = firstClickCell.parentNode.rowIndex;
            const topLeftCol = firstClickCell.cellIndex;

            // Ensure the second click is at a cell that is bottom-right of the first click
            if (row >= topLeftRow && col >= topLeftCol) {
                // Check if any cell within the rectangle is already colored or if the selected color is already used
                for (let i = Math.min(topLeftRow, row); i <= Math.max(topLeftRow, row); i++) {
                    for (let j = Math.min(topLeftCol, col); j <= Math.max(topLeftCol, col); j++) {
                        if (gameBoard[i][j]) {
                            firstClickCell.classList.remove('selected');
                            firstClickCell = null;
                            return;
                        }
                    }
                }

                // Color cells within the rectangle with the selected color
                for (let i = Math.min(topLeftRow, row); i <= Math.max(topLeftRow, row); i++) {
                    for (let j = Math.min(topLeftCol, col); j <= Math.max(topLeftCol, col); j++) {
                        gameBoard[i][j] = selectedColor;
                        const targetCell = gameBoardElement.rows[i].cells[j];
                        targetCell.style.backgroundColor = selectedColor;
                    }
                }
            }

            // Reset first click
            firstClickCell.classList.remove('selected');
            firstClickCell = null;
        }
    });
});

function renderGameBoard(selectedGame) {
    const size = selectedGame.size;
    gameBoard = Array.from({ length: size }, () => Array(size).fill(''));

    const tableBody = document.createElement('tbody');

    for (let i = 0; i < size; i++) {
        const row = document.createElement('tr');
        for (let j = 0; j < size; j++) {
            const cell = document.createElement('td');
            cell.classList.add('cell');
            row.appendChild(cell);

            // Set numbers from the game data
            const index = selectedGame.row.findIndex((r, idx) => r === i + 1 && selectedGame.col[idx] === j + 1);
            if (index !== -1) {
                cell.textContent = selectedGame.num[index];
            }
        }
        tableBody.appendChild(row);
    }

    const gameBoardElement = document.getElementById('gameBoard');
    gameBoardElement.innerHTML = '';
    gameBoardElement.appendChild(tableBody);
}

function renderColorPalette(colors) {
    const colorPalette = document.getElementById('colorPalette');
    colorPalette.innerHTML = '';

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

        colorPalette.appendChild(colorDiv);
    });
}
