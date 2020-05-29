<?php
    session_start();
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $regno = $_SESSION['regno'];
    $year = $_SESSION['year'];
    $sec = $_SESSION['sec'];
?>
<html>
    <head>
        <style>
            #show{
                color: white;
                position: absolute;
                top: 40vh;
                left: 50vh;
                font-size: 37px;;
            }
        </style>
        <script src= 
            "https://code.jquery.com/jquery-3.4.0.min.js"> 
        </script> 
    </head>
    <body>
        <?php
        echo "<div id = 'show'>
        Student Reg-No &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$regno<br>
        Student Name &nbsp; &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$name<br>
        Student Email &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$email<br>
        Student Year &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$year<br>
        Student sec &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$sec<br>
        University Name &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ABC University, Heaven<br>
    </div>"
        ?>
    </body>
</html>