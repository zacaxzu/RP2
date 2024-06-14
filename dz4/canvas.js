// Initialize canvas and draw elements
const context = initializeCanvas();
drawBackground(context);
drawRectangles(context);
drawArc(context);
drawGoal(context);
drawPlayers(context, situacija[0].tim1);
drawPlayers(context, situacija[0].tim2);
drawBallPath(context, situacija[0]);