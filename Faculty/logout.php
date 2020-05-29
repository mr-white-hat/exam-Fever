<?php
session_start();
$name = $_SESSION['name'];
?>
<html>
    <head>
        <title>Success</title>
        <link rel = "icon" href = "icon.png">
        <style>
            body {
                background-color: black;
            }
            .form{
                margin-block-end: 0;
                margin-block-start: 0;
                scroll-margin-block: 0;
                box-shadow: 0 15px 30px 0 grey;
                width: 350px;
                margin: auto;
                border: 3px solid black;
                z-index: 9;
                border-radius: 18.3px;
                padding: 10px;
                background-color: gold;
                border-radius: 15px;
                text-align: center;
            }
            p {
                font-weight: bold;
            }
            #home {
                padding: 10px 30px;
                color: white;
                background-color: black;
                cursor: pointer;
                text-decoration: None;
                margin-bottom: 500px;
            }
        </style>
        <script>
            var counter = 3;
            setInterval(function() {
            counter--;
            document.getElementById("count").innerHTML = counter;
            }, 1000);
        </script>
    </head>
    <body>
        <div class = "form">
            <h1>Logout Sucessful</h1>
            <h3><?= 'Thank you, '.$name.'!!' ?></h3>
            <p>
                <?php
                    session_unset();
                    session_destroy();
                    header("Refresh: 3; url = ../index.php");
                ?>
                <b>Redirecting in <span id = "count">3</span></b>
            </p>
            <br>
            <br>
        </div>
    </body>
</html>