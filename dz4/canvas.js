// Initialize canvas and draw elements
const context = initializeCanvas();
drawBackground(context);
drawRectangles(context);
drawArc(context);
drawGoal(context);
drawPlayers(context, tim1);
drawBallPath(context, tim1);