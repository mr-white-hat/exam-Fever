<?php
    session_start();
    $name = $_SESSION['name'];
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $qual = $_SESSION['qual'];
    $djoin = $_SESSION['djoin'];
    $depart = $_SESSION['depart'];
    $mysqli = new mysqli('localhost', 'root', '', $id) or die($mysqli->error);
    $sql = "SHOW TABLES FROM $id";
    $result = mysqli_query($mysqli, $sql);
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
        <script src= "https://code.jquery.com/jquery-3.4.0.min.js"> 
        </script> 
    </head>
    <body>
        <?php
        echo "<div id = 'show'>
                Faculty ID &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$id<br>
                Faculty Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$name<br>
                Faculty Email &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$email<br>
                Qualifation &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$qual<br>
                Faculty DoJ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$djoin - Present<br>
                Department Name &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$depart<br>
                University Name &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ABC University, Heaven<br></div>"
        ?>
    </body>
</html>