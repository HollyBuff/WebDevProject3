// --- Variables ---

var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");

// X, Y position and size of ball

var xPos = canvas.width/2;
var yPos = canvas.height-20;
var xMove = (Math.random()*5)+2;
var yMove = (Math.random()*5)+2;
var ballRadius = 10;

// Paddle size and position

var paddleHeight = 10;
var paddleWidth = 90;
var paddleX = (canvas.width-paddleWidth)/2;
var paddleLeft = false;
var paddleRight = false;
var offset = 10;

/////////// Changes Made 1/////////////////////
// Bricks
var brickRows = 2;
var brickColumns = 2;
var brickWidth = 200;
var brickHeight = 25;
var brickPadding = 10;
var brickOffsetTop = 50;
var brickOffsetLeft = 200;

// Brick 3, power up - increase score
// this is a random number between 1 and 2 for placement (change the 2 to be whatever the column and bricks are)
// num1 is the number of columns/ num2 is the number of rows (so they have to match the row and column count)
var num1 = Math.floor(Math.random() * 2) + 1;
var num2 = Math.floor(Math.random() * 2) + 1;

/*var num3 = Math.floor(Math.random() * 1) + 1;
while((num3 == num2) && (num3 == num2))
{
    num3 = Math.floor(Math.random() * 1 + 1);
}*/


// these are important in the bricks3 section to make sure level 2 shows up properly
var counter = 0;
var counter2 = 0;

var counter3 = 0;
var counter4 = 0;
/////////////// End of Changes 1//////////////


// Uncategorized variables
var score = 0;
var ballColor = randomColor();
// End of variables

// Event listeners
document.addEventListener('keydown', pressed, false);
document.addEventListener('keyup', notPressed, false);
document.addEventListener("mousemove", mouseMove, false);
// End of event listeners

// Function that is changing value of variable when key is pressed
function pressed(e) {
    if(e.keyCode == 39) {
        paddleRight = true;
    }
    else if (e.keyCode == 37) {
        paddleLeft = true;
    }
    else if (e.keyCode == 32) {
        document.location.reload();
    }
}

// Function that is changing value of variable when key is let go
function notPressed(e) {
    if(e.keyCode == 39) {
        paddleRight = false;
    }
    else if (e.keyCode === 37) {
        paddleLeft = false;
    }
}

// Function that lets the player control the paddle with mouse
function mouseMove(e) {
    var relativeX = e.clientX - canvas.offsetLeft;
    if(relativeX > 0 && relativeX < canvas.width) {
        paddleX = relativeX - paddleWidth/3;
    }
}

/////////// Changes Made 2/////////////////////
// Bricks array
var bricks = [];  // original bricks
var bricks2 = []; // second bricks array for the 2nd level
var bricks3 = []; // 3rd bricks array for the score power ups
var bricks4 = []; // 4th power up for the padel size
for(c=0; c<brickColumns; c++) {
    bricks[c] = [];
    bricks2[c] = [];
    bricks3[c] = [];
    bricks4[c] = [];
    for(r=0; r<brickRows; r++) {
        bricks[c][r] = { x: 0, y: 0, status: 1 };
        bricks2[c][r] = { x: 0, y: 0, status: 1 };
        bricks3[c][r] = { x: 0, y: 0, status: 1 };
        bricks4[c][r] = { x: 0, y: 0, status: 1 };
    }
}
/////////////// End of Changes 2//////////////

// Function that creates scorebar and shows your current score (+1 for destroying a brick)
function scorebar() {
    ctx.font = "14px Arial";
    ctx.fillStyle = "#1abc9c";
    ctx.fillText("Your score = "+score, 10, 15);
}

// Function that creates the ball
function ball() {
    ctx.beginPath();
    ctx.arc(xPos, yPos, ballRadius, 0, Math.PI*2);
    ctx.fillStyle = ballColor;
    ctx.fill();
    ctx.closePath();
}


// Function that creates the paddle

function paddle() {
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height-paddleHeight-offset, paddleWidth, paddleHeight);
    ctx.fillStyle = "#3498db";
    ctx.fill();
    ctx.closePath();
}

/////////// Changes Made 3/////////////////////
// Function that creates bricks
function createBricks() {
    for(c=0; c<brickColumns; c++) {
        for(r=0; r<brickRows; r++) {

            if(bricks[c][r].status == 1) {

                var brickXpos = (c*(brickWidth+brickPadding))+brickOffsetLeft;
                var brickYpos = (r*(brickHeight+brickPadding))+brickOffsetTop;
                bricks[c][r].x = brickXpos;
                bricks[c][r].y = brickYpos;
                ctx.beginPath();
                ctx.rect(brickXpos, brickYpos, brickWidth, brickHeight);
                ctx.fillStyle = "#e74c3c";
                ctx.fill();
                ctx.closePath();
            }
        }
    }

}

// level 2 bricks creation
function createBricks2() {
    for(c=0; c<brickColumns; c++) {
        for(r=0; r<brickRows; r++) {
            if(bricks2[c][r].status == 1) {
                var brickXpos = (c*(brickWidth+brickPadding))+brickOffsetLeft;
                var brickYpos = (r*(brickHeight+brickPadding))+brickOffsetTop;
                bricks2[c][r].x = brickXpos;
                bricks2[c][r].y = brickYpos;
                ctx.beginPath();
                ctx.rect(brickXpos, brickYpos, brickWidth, brickHeight);
                ctx.fillStyle = "#db3ce7";
                ctx.fill();
                ctx.closePath();
            }
        }
    }
}

// level 3 bricks creation for power up
function createBricks3() {
    for(c=0; c<brickColumns; c+=num1) {
        for(r=0; r<brickRows; r+=num2) {
            if(bricks3[c][r].status == 1) {
                if(counter2 == 0)
                    counter++;
            
                var brickXpos = (c*(brickWidth+brickPadding))+brickOffsetLeft;
                var brickYpos = (r*(brickHeight+brickPadding))+brickOffsetTop;
                bricks3[c][r].x = brickXpos;
                bricks3[c][r].y = brickYpos;
                ctx.beginPath();
                ctx.rect(brickXpos, brickYpos, brickWidth, brickHeight);
                ctx.fillStyle = "#e7db3c";
                ctx.fill();
                ctx.closePath();
            }
        }
    }

    counter2++;
}

// for padel size
function createBricks4() {
    for(c=0; c<brickColumns; c+=1) {
        for(r=1; r<brickRows; r+=1) {
            if(bricks4[c][r].status == 1) {
                var brickXpos = (c*(brickWidth+brickPadding))+brickOffsetLeft;
                var brickYpos = (r*(brickHeight+brickPadding))+brickOffsetTop;
                bricks4[c][r].x = brickXpos;
                bricks4[c][r].y = brickYpos;
                ctx.beginPath();
                ctx.rect(brickXpos, brickYpos, brickWidth, brickHeight);
                ctx.fillStyle = "#aa42f4";
                ctx.fill();
                ctx.closePath();
            }
        }
    }
}
// Function that detects collision with brick

function bricksCollision() {
    for(c=0; c<brickColumns; c++) {
        for(r=0; r<brickRows; r++) {
            var b = bricks[c][r];
            if(b.status == 1) {
                if(xPos > b.x && xPos < b.x+brickWidth && yPos > b.y && yPos < b.y+brickHeight) {
                    yMove = -yMove;
                    b.status = 0;
                    score++;
                    paddleWidth = 90;
                    ballColor = randomColor();
                }
            }
        }
    }
}
function bricksCollision2() {
    for(c=0; c<brickColumns; c++) {
        for(r=0; r<brickRows; r++) {
            var b = bricks2[c][r];
            if(b.status == 1) {
                if(xPos > b.x && xPos < b.x+brickWidth && yPos > b.y && yPos < b.y+brickHeight) {
                    yMove = -yMove;
                    b.status = 0;
                    score++;
                    paddleWidth = 90;
                    ballColor = randomColor();
                }
            }
        }
    }
}

function bricksCollision3() {
    for(c=0; c<brickColumns; c+=num1) {
        for(r=0; r<brickRows; r+=num2) {
            var b = bricks3[c][r];
            if(b.status == 1) {
                if(xPos > b.x && xPos < b.x+brickWidth && yPos > b.y && yPos < b.y+brickHeight) {
                    yMove = -yMove;
                    b.status = 0;
                    score++;
                    paddleWidth = 90;
                    ballColor = randomColor();
                }
            }
        }
    }
}

function bricksCollision4() {
    for(c=0; c<brickColumns; c+=1) {
        for(r=1; r<brickRows; r+=1) {
            var b = bricks4[c][r];
            if(b.status == 1) {
                if(xPos > b.x && xPos < b.x+brickWidth && yPos > b.y && yPos < b.y+brickHeight) {
                    yMove = -yMove;
                    b.status = 0;
                    paddleHeight = 10;
                    paddleWidth = 50;
                    ballColor = randomColor();
                }
            }
        }
    }
}
/////////////// End of Changes 3//////////////

// Function that controls the paddle and ball behaviour/movement
function draw() {
    if(score < (((brickColumns * brickRows)-counter) + (counter * 2))) // this is for changing the levels to make sure we dont change the levels when we arent supposed to
    {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        createBricks();
        ball();
        paddle();
        bricksCollision();
        scorebar();

        // add the brick creation and collision for 3 and 4
        createBricks3();
        bricksCollision3();

        createBricks4();
        bricksCollision4();

        if(xPos + xMove > canvas.width-ballRadius || xPos + xMove < ballRadius) {
            xMove = -xMove;
        }
        if(yPos + yMove < ballRadius) {
            yMove = -yMove;
        }
        else if (yPos + yMove > canvas.height-ballRadius-offset) {
            if (xPos > paddleX && xPos < paddleX + paddleWidth) {
                yMove = -yMove;
            }
            else {
                alert("Game over, try again!");
                document.location.reload();
            }
        }
        if(paddleRight && paddleX < canvas.width-paddleWidth) {
            paddleX += 7.5;
        }
        else if(paddleLeft && paddleX > 0) {
            paddleX -= 7.5;
        }
        xPos += xMove;
        yPos += yMove;

        requestAnimationFrame(draw);
    }
    else
    {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        createBricks2();
        ball();
        paddle();
        bricksCollision2();
        scorebar();

        if(xPos + xMove > canvas.width-ballRadius || xPos + xMove < ballRadius) {
            xMove = -xMove;
        }
        if(yPos + yMove < ballRadius) {
            yMove = -yMove;
        }
        else if (yPos + yMove > canvas.height-ballRadius-offset) {
            if (xPos > paddleX && xPos < paddleX + paddleWidth) {
                yMove = -yMove;
            }
            else {
                alert("Game over, try again!");
                document.location.reload();
            }
        }
        if(paddleRight && paddleX < canvas.width-paddleWidth) {
            paddleX += 7.5;
        }
        else if(paddleLeft && paddleX > 0) {
            paddleX -= 7.5;
        }
        xPos += xMove;
        yPos += yMove;

        requestAnimationFrame(draw);
    }
}

// Function that returns random color

function randomColor() {
    var r = 255*Math.random()|0,
        g = 255*Math.random()|0,
        b = 255*Math.random()|0;
    return 'rgb(' + r + ',' + g + ',' + b + ')';
}

draw();