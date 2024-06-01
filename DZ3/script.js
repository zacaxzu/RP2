let selectedColor = ''; // Global variable to store selected color
let gameBoard = []; // Array to store game board data
let firstClickCell = null; // Variable to store the first clicked cell
const usedColors = new Set(); // Set to keep track of used colors

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
            usedColors.clear(); // Clear the used colors when a new game starts
            renderGameBoard(game[selectedGameIndex]);
            renderColorPalette(game[selectedGameIndex].color);
            selectedColor = ''; // Clear the selected color
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
        // Check if the selected color has already been used
        if (usedColors.has(selectedColor)) {
            alert('This color has already been used for a rectangle.');
            // Uncheck the radio button if the color is already used
            event.target.checked = false;
            selectedColor = '';
        }
    });

    // Add event listener to game board cells to handle rectangle drawing
    gameBoardElement.addEventListener('click', (event) => {
        const cell = event.target;
        if (!cell.classList.contains('cell')) return; // Ignore clicks on elements other than cells

        // Check if the selected color has already been used
        if (selectedColor === '') {
            alert('Please select a color.');
            return;
        }

        if (usedColors.has(selectedColor)) {
            alert('This color has already been used for a rectangle.');
            return;
        }

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
            
            const bottomRightRow = row;
            const bottomRightCol = col;
            console.log(bottomRightRow);

            // Ensure the second click is at a cell that is bottom-right of the first click
            if (row >= topLeftRow && col >= topLeftCol) {
                // Check if any cell within the rectangle is already colored
                let isOccupied = false;
                for (let i = topLeftRow; i <= row; i++) {
                    for (let j = topLeftCol; j <= col; j++) {
                        if (gameBoard[i][j]) {
                            isOccupied = true;
                            break;
                        }
                    }
                    if (isOccupied) break;
                }

                if (isOccupied) {
                    alert('Some cells within the selected rectangle are already colored.');
                    firstClickCell.classList.remove('selected');
                    firstClickCell = null;
                    return;
                }

                // Color cells within the rectangle with the selected color
                for (let i = topLeftRow; i <= row; i++) {
                    for (let j = topLeftCol; j <= col; j++) {
                        gameBoard[i][j] = selectedColor;
                        const targetCell = gameBoardElement.rows[i].cells[j];
                        targetCell.style.backgroundColor = selectedColor;
                    }
                }

                // Call the function to check and highlight the number in red
                checkAndHighlightNumber(gameBoardElement, topLeftRow, topLeftCol, bottomRightRow, bottomRightCol, selectedColor);

                // Mark the color as used
                usedColors.add(selectedColor);
            } else {
                alert('You need to select the bottom-right corner after selecting the top-left corner.');
            }

            // Reset first click
            firstClickCell.classList.remove('selected');
            firstClickCell = null;
        }
    });

    // Add event listener for right-click to handle rectangle deletion
    gameBoardElement.addEventListener('contextmenu', (event) => {
        event.preventDefault();
        const cell = event.target;
        if (!cell.classList.contains('cell')) return; // Ignore clicks on elements other than cells

        const row = cell.parentNode.rowIndex;
        const col = cell.cellIndex;
        const colorToDelete = gameBoard[row][col];

        if (!colorToDelete) {
            // Cell is not colored
            return;
        }

        // Find and clear the entire rectangle with the same color
        for (let i = 0; i < gameBoard.length; i++) {
            for (let j = 0; j < gameBoard[i].length; j++) {
                if (gameBoard[i][j] === colorToDelete) {
                    gameBoard[i][j] = '';
                    const targetCell = gameBoardElement.rows[i].cells[j];
                    targetCell.style.backgroundColor = '';
                }
            }
        }

        // Mark the color as unused
        usedColors.delete(colorToDelete);
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

    // Clear any selected color
    selectedColor = '';
    // Ensure no radio button is checked
    const radioButtons = colorPalette.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(button => {
        button.checked = false;
    });
}

function checkAndHighlightNumber(gameBoardElement, topLeftRow, topLeftCol, bottomRightRow, bottomRightCol, color) {
    const rectangleSize = (bottomRightRow - topLeftRow + 1) * (bottomRightCol - topLeftCol + 1);

    for (let i = topLeftRow; i <= bottomRightRow; i++) {
        for (let j = topLeftCol; j <= bottomRightCol; j++) {
            const cell = gameBoardElement.rows[i].cells[j];
            if (cell.textContent && parseInt(cell.textContent) === rectangleSize) {
                cell.style.color = 'red'; // Highlight the number text in red
            }
        }
    }
}