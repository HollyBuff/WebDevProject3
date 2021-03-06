<?php
    session_start ();

    if(isset($_SESSION['use']))   // Checking whether the session is already there or not if                            // true then header redirect it to the home page directly 
    {
        header("Location:Initial.html"); 
    }
    else 
    if ($_SESSION["pass_userName"] != null)
    {
        //echo "<script>alert('Welcome Back, ".$_SESSION["pass_userName"]."');</script>";
        echo '<h1>Welcome Back, ' . $_SESSION["pass_userName"] . '</h1>';
        $name = $_SESSION["pass_userName"];
    }

 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
    canvas { background: #00FFFF; display: block; margin: auto;}
    body {
        font: 12px arial;
        color: #222;
        text-align: center;
        padding: 35px;
    }

    h1 {
        font-family: Helvetica;
    }

    .panel{

        margin-right: 3px;
    }

    .button {
        background-color: #4CAF50;
        border: none;
        color: white;
        margin-right: 30%;   
        margin-left: 30%;
        text-decoration: none;
        display: block;
        font-size: 16px;
        cursor: pointer;
        width:30%;
        height:40px;
        margin-top: 5px;
         
    }
    input[type=text]{
        width:100%;
        margin-top:5px; 
    }


    .chat_wrapper {
        width: 70%;
        height:472px;
        margin-right: auto;
        margin-left: auto;
        background: #3B5998;
        border: 1px solid #999999;
        padding: 10px;
        font: 14px 'lucida grande',tahoma,verdana,arial,sans-serif;
    }
    .chat_wrapper .message_box {
        background: #F7F7F7;
        height:350px;
            overflow: auto;
        padding: 10px 10px 20px 10px;
        border: 1px solid #999999;
    }
    .chat_wrapper  input{
        //padding: 2px 2px 2px 5px;
    }
    .system_msg{color: #BDBDBD;font-style: italic;}
    .user_name{font-weight:bold;}
    .user_message{color: #88B6E0;}

    @media only screen and (max-width: 720px) {
        /* For mobile phones: */
        .chat_wrapper {
            width: 95%;
        height: 40%;
        }
        

        .button{ width:100%;
        margin-right:auto;   
        margin-left:auto;
        height:40px;}
        
                    
    }

    button {
        margin: 10px;
        padding: 10px;
    }
</style>

<title>Chat - Customer Module</title>
</head>

<body>

    <canvas id="myCanvas" width="960" height="640"></canvas>

    <button id="play" type="button">Play</button>
    <button id="pause" type="button">Pause</button>



    <div class="chat_wrapper">
    <div class="message_box" id="message_box"></div>
    <div class="panel">
    <input type="text" name="name" id="name" placeholder="Your Name" maxlength="15" />

    <input type="text" name="message" id="message" placeholder="Message" maxlength="80" 
    onkeydown = "if (event.keyCode == 13)document.getElementById('send-btn').click()"  />

    </div>
        <button id="send-btn" class=button>Send</button>
    </div>

        <?php 
    $colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
    $user_colour = array_rand($colours);
    ?>


    <script src="jquery-3.1.1.js"></script>


    <script language="javascript" type="text/javascript"> 
        var canvas = document.getElementById("myCanvas");
        var ctx = canvas.getContext("2d");
        var ballRadius = 10;
        var x = canvas.width/2; // start off possition.
        var y = canvas.height-70; // start off position
        var dx = 5; // control gravity / dropping angel and speed
        var dy = -5;// control gravity / dropping angel and speed
        var tempdy = dy;
        var paddleHeight = 10;
        var paddleWidth = 75;
        var paddleX = (canvas.width-paddleWidth)/2;//space outside the paddle in half
        var rightPressed = false;//mouse will move to right automatically when user is not controlling
        var leftPressed = false;//mouse will move to left automatically when user is not controlling.
        var brickRowCount = 2;
        var brickColumnCount = 1;
        var brickWidth = 480; 
        var brickRowCount2 = 14;
        var brickColumnCount2 = 6;
        var brickWidth2 = 60;
        var brickHeight = 15; 
        var brickPadding = 8;//gap in between each brick
        var brickOffsetTop = 30;
        var brickOffsetLeft = 10;
        var score = 0;
        var lives = 3;
        var level = 1;

        document.getElementById("pause").addEventListener("click", pause);
        function pause(e)
        {
            dx = 0;
            dy = 0;
            console.log("paused");
        }

        document.getElementById("play").addEventListener("click", play);
        function play(e)
        {
            dx = 5;
            dy = tempdy;
            console.log("play");
        }

    $(document).ready(function(){
        //create a new WebSocket object.
        var wsUri = "ws://ec2-35-163-94-170.us-west-2.compute.amazonaws.com:9090/demo/server.php";  
        websocket = new WebSocket(wsUri); 
        
        websocket.onopen = function(ev) { // connection is open 
            $('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
        }

        <?php echo "var myname = '" .$name . "'"; ?>

        function sendScore() {
            var msg = {
                message: score,
                name: myname,
                color : '<?php echo $colours[$user_colour]; ?>'
                };
                //convert and send data to server
                websocket.send(JSON.stringify(msg));
            }

        $('#send-btn').click(function(){ //use clicks message send button   
            var mymessage = $('#message').val(); //get message text
            
            if(myname == ""){ //empty name?
                alert("Enter your Name please!");
                return;
            }
            if(mymessage == ""){ //emtpy message?
                alert("Enter Some message Please!");
                return;
            }
            document.getElementById("name").style.visibility = "hidden"

            
            var objDiv = document.getElementById("message_box");
            objDiv.scrollTop = objDiv.scrollHeight;

            //prepare json data
            var msg = {
            message: mymessage,
            name: myname,
            color : '<?php echo $colours[$user_colour]; ?>'
            };
            //convert and send data to server
            websocket.send(JSON.stringify(msg));
        });
        
        //#### Message received from server?
        websocket.onmessage = function(ev) {
            var msg = JSON.parse(ev.data); //PHP sends Json data
            var type = msg.type; //message type
            var umsg = msg.message; //message text
            var uname = msg.name; //user name
            var ucolor = msg.color; //color

            if(type == 'usermsg') 
            {
                $('#message_box').append("<div><span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");
            }
            if(type == 'system')
            {
                $('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
            }
            
            $('#message').val(''); //reset text
            
            var objDiv = document.getElementById("message_box");
            objDiv.scrollTop = objDiv.scrollHeight;
        };
        
        websocket.onerror   = function(ev){$('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");}; 
        websocket.onclose   = function(ev){$('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");}; 
   


        

        var bricks = [];
        for(c=0; c<brickColumnCount; c++) {
            bricks[c] = [];
            for(r=0; r<brickRowCount; r++) {
                bricks[c][r] = { x: 0, y: 0, status: 1 };
            }
        }

        var bricks2 = [];
        for(c=0; c<brickColumnCount2; c++) {
            bricks2[c] = [];
            for(r=0; r<brickRowCount2; r++) {
                bricks2[c][r] = { x: 0, y: 0, status: 1, life: 2};
            }
        }

        document.addEventListener("keydown", keyDownHandler, false);
        document.addEventListener("keyup", keyUpHandler, false);
        document.addEventListener("mousemove", mouseMoveHandler, true);

        function keyDownHandler(e) { // let key board to control the paddle
            if(e.keyCode == 39) {
                rightPressed = true;
            }
            else if(e.keyCode == 37) {
                leftPressed = true;
            }
        }
        function keyUpHandler(e) { // let key board to control the paddle
            if(e.keyCode == 39) {
                rightPressed = false;
            }
            else if(e.keyCode == 37) {
                leftPressed = false;
            }
        }
        function mouseMoveHandler(e) {
            var relativeX = e.clientX - canvas.offsetLeft;
            if(relativeX > 0 && relativeX < canvas.width) {
                paddleX = relativeX - paddleWidth/2;
            }
        }

        

        function collisionDetection() {
            for(c=0; c<brickColumnCount; c++) {
                for(r=0; r<brickRowCount; r++) {
                    var b = bricks[c][r];
                    if(b.status == 1) {
                        if(x > b.x && x < b.x+brickWidth && y > b.y && y < b.y+brickHeight) { // if hit the brick 
                            dy = -dy; // control the ball to go the oposit direction
                            tempdy = dy;
                            b.status = 0;
                            score++;
                            sendScore();
                            
                            
                        }
                    }
                }
            }
        }

        function collisionDetection2() {
            for(c=0; c<brickColumnCount2; c++) {
                for(r=0; r<brickRowCount2; r++) {
                    var b = bricks2[c][r];
                    if(b.status == 1) {
                        if(x > b.x && x < b.x+brickWidth2 && y > b.y && y < b.y+brickHeight) { // if hit the brick 
                            dy = -dy; // control the ball to go the oposit direction
                            tempdy = dy;
                            bricks2[c][r].life --;
                            console.log(bricks2[c][r].life);
                            if(bricks2[c][r].life==0){
                                b.status = 0;
                            }
                            score++;
                            sendScore();
                            if(score == 2*(brickRowCount2*brickColumnCount2)+(brickRowCount*brickColumnCount)) { //every time you hit 
                                alert("YOU WIN, CONGRATS!");
                                document.location.reload();

                            
                            }
                        }
                    }
                }
            }
        }

        function drawBall() {
            ctx.beginPath();
            ctx.arc(x, y, ballRadius, 0, Math.PI*2);
            ctx.fillStyle = "#BC8F8F";
            ctx.fill();
            ctx.closePath();
        }
        function drawPaddle() {
            ctx.beginPath();
            ctx.rect(paddleX, canvas.height-paddleHeight, paddleWidth, paddleHeight);
            ctx.fillStyle = "#0095DD";
            ctx.fill();
            ctx.closePath();
        }
        function drawBricks() {
            
            for(c=0; c<brickColumnCount; c++) {
                for(r=0; r<brickRowCount; r++) {
                    if(bricks[c][r].status == 1) {
                        var brickX = (r*(brickWidth+brickPadding))+brickOffsetLeft;
                        var brickY = (c*(brickHeight+brickPadding))+brickOffsetTop;
                        bricks[c][r].x = brickX;
                        bricks[c][r].y = brickY;
                    
                        ctx.beginPath();
                        ctx.rect(brickX, brickY, brickWidth, brickHeight);
                        ctx.fillStyle = "#A52A2A";
                        ctx.fill();
                        ctx.closePath();
                    }
                }
            }
        }

        function drawBricks2() {
            
            for(c=0; c<brickColumnCount2; c++) {
                for(r=0; r<brickRowCount2; r++) {
                    if(bricks2[c][r].status == 1) {
                    
                        var brickX = (r*(brickWidth2+brickPadding))+brickOffsetLeft;
                        var brickY = (c*(brickHeight+brickPadding))+brickOffsetTop;
                    
                        bricks2[c][r].x = brickX;
                        bricks2[c][r].y = brickY;
                        
                       
                        ctx.beginPath();
                        ctx.rect(brickX, brickY, brickWidth2, brickHeight);
                        ctx.fillStyle = "#35ad2d";
                        ctx.fill();
                        ctx.closePath();
                    }
                }
            }
        }

        //var timer = setInterval(randInt,2000);
           

        function randInt() {
            var Rand =Math.floor((Math.random()* 5)+1);
            return Rand;
        }

        function drawScore() {
            ctx.font = "16px Arial";
            ctx.fillStyle = "#0095DD";
            ctx.fillText("Score: "+score, 8, 20);
        }
        function drawLives() {
            ctx.font = "16px Arial";
            ctx.fillStyle = "#0095DD";
            ctx.fillText("Lives: "+lives, canvas.width-65, 20);
        }

        function drawLevel() {
            ctx.font = "16px Arial";
            ctx.fillStyle = "#0095DD";
            ctx.fillText("Level: "+level, canvas.width/2, 20);
        }

        function draw() {
            if(score < brickRowCount*brickColumnCount)
            {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                drawBricks();
                drawBall();
                drawPaddle();
                drawScore();
                drawLives();
                drawLevel();
                collisionDetection();

                if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) {
                    dx = -dx;
                }
                if(y + dy < ballRadius) {
                    dy = -dy;
                }
                else if(y + dy > canvas.height-ballRadius) {
                    if(x > paddleX && x < paddleX + paddleWidth) {
                        dy = -dy;
                    }
                    else {
                        lives--;
                        if(lives == -1) {
                            alert("GAME OVER");
                            document.location.reload();
                        }
                        else {
                            x = canvas.width/2;
                            y = canvas.height-70;
                            dx = 5;
                            dy = -5;
                            paddleX = (canvas.width-paddleWidth)/2;
                        }
                    }
                }

                if(rightPressed && paddleX < canvas.width-paddleWidth) {
                    paddleX += 7;
                }
                else if(leftPressed && paddleX > 0) {
                    paddleX -= 7;
                }

                x += dx;
                y += dy;
                requestAnimationFrame(draw);
            }

            else {
                level=2;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                drawBricks2();
                drawBall();
                drawPaddle();
                drawScore();
                drawLives();
                drawLevel();
                collisionDetection2();

                if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) {
                    dx = -dx;
                }
                if(y + dy < ballRadius) {
                    dy = -dy;
                }
                else if(y + dy > canvas.height-ballRadius) {
                    if(x > paddleX && x < paddleX + paddleWidth) {
                        dy = -dy;
                    }
                    else {
                        lives--;
                        if(lives == -1) {
                            alert("GAME OVER");
                            document.location.reload();
                        }
                        else {
                            x = canvas.width/2;
                            y = canvas.height-70;
                            dx = 5;
                            dy = -5;
                            paddleX = (canvas.width-paddleWidth)/2;
                        }
                    }
                }

                if(rightPressed && paddleX < canvas.width-paddleWidth) {
                    paddleX += 7;
                }
                else if(leftPressed && paddleX > 0) {
                    paddleX -= 7;
                }

                x += dx;
                y += dy;
                requestAnimationFrame(draw);
            }
        }
        draw();
    }); 

    
   
    
    </script>

    <?php
    if (! isset ( $_SESSION ['name'] )) {
        loginForm ();
    } 
    else {
        ?>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">
                    Welcome, <b><?php echo $_SESSION['name']; ?></b>
                </p>
                <p class="logout">
                    <a id="exit" href="#">Exit Chat</a>
                </p>
                <div style="clear: both"></div>
            </div>

            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" size="63" /> 
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
        <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
        <script type="text/javascript">
        // jQuery Document
        $(document).ready(function(){
        });

    //jQuery Document
    $(document).ready(function(){
        //If user wants to end session
        $("#exit").click(function(){
            var exit = confirm("Are you sure you want to end the session?");
            if(exit==true){window.location = 'game.php?logout=true';}     
        });
    });
 

 
    setInterval (loadLog, 2500);


    </script>
    <?php
        }
        ?>
        <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
        <script type="text/javascript">
    </script>

</body>
</html>