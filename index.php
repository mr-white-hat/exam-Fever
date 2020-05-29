<?php
    isset($_SESSION) || session_start();
    $mysqli = new mysqli('localhost', 'root', '', 'exam-fever') or die($mysqli->error);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['slogin'])){
            $email = $mysqli->escape_string($_POST['semail']);
            $result = $mysqli->query("SELECT *FROM student WHERE email = '$email'");
            if ($result->num_rows == 0) {
                $_SESSION['message'] = "User with that email doesn't exist!";
                header("location: error.php");
            }
            else {
                $user = $result->fetch_assoc();
                if (md5($_POST['spsw']) == $user['pass']) {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['regno'] = $user['reg.no'];
                    $_SESSION['year'] = $user['year'];
                    $_SESSION['sec'] = $user['sec'];
                    $_SESSION['logged_in'] = true;
                    header("location: ./Student/success.php");
                }
                else {
                    $_SESSION['message'] = "You have entered wrong password, try again!";
                    header("location: error.php");
                }
            }
        }
        elseif (isset($_POST['flogin'])){
            $email = $mysqli->escape_string($_POST['femail']);
            $result = $mysqli->query("SELECT *FROM faculty WHERE email = '$email'");
            if ($result->num_rows == 0) {
                $_SESSION['message'] = "User with that email doesn't exist!";
                header("location: error.php");
            }
            else {
                $user = $result->fetch_assoc();
                if (md5($_POST['fpsw']) == $user['pass']) {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['qual'] = $user['qual'];
                    $_SESSION['djoin'] = $user['djoin'];
                    $_SESSION['depart'] = $user['depart'];
                    $_SESSION['logged_in'] = true;
                    header("location: ./Faculty/success.php");
                }
                else {
                    $_SESSION['message'] = "You have entered wrong password, try again!";
                    header("location: error.php");
                }
            }
        }
    }
?>

<html>
    <head>
    <title>exam-Fever</title>
    <link rel="icon" href="icon.png">
    <link rel = "stylesheet" href = "style.css">
    <script>
        $(document).mouseup(function (e) { 
                if ($(e.target).closest(".form-popup").length === 0) { 
                    $("#mySForm").hide(); 
                    $("#myFForm").hide();
                } 
            });
        function openSForm() {
            document.getElementById("mySForm").style.display = "block";
            document.getElementById("student").style.color = "red";
            document.getElementById("faculty").style.color = "black";
            document.getElementById("myFForm").style.display = "none";
        }
        function openFForm() {
            document.getElementById("myFForm").style.display = "block";
            document.getElementById("mySForm").style.display = "none";
            document.getElementById("faculty0").style.color = "red";
            document.getElementById("student0").style.color = "black";
        }
        
        function closeForm() {
            document.getElementById("myFForm").style.display = "none";
            document.getElementById("mySForm").style.display = "none";
        }
    </script>
    </head>
    <body>
        <div id = "web-container">
            <div class = "header">
                <a href = #><img class = "logo" src = "logo.png"></a>
                <button class = "login-btn" onclick = "openSForm()">Login</button>

                <div class = "form-popup" id = "mySForm">
                    <form class="form_container" enctype = "multipart/form-data" method = "POST">
                      <h1 id = "student" onclick = "openSForm()">Student</h1><h1 class = "lin">|</h1><h1 id = "faculty" onclick = "openFForm()">Faculty</h1>

                      <label class = "em" for = "semail"><b>Email</b></label>
                      <input type = "text" placeholder = "Enter Email" name = "semail" required>
                  
                      <label for = "spsw"><b>Password</b></label>
                      <input type = "password" placeholder = "Enter Password" name = "spsw" required>
                  
                      <button type = "submit" name = "slogin" class = "btn">Login</button>
                      <button type = "button" class = "btn cancel" onclick = "closeForm()">Close</button>
                    </form>
                </div>  

                <div class = "form-popup" id = "myFForm">
                    <form class = "form_container" enctype = "multipart/form-data" method = "POST">
                      <h1 id = "student0" onclick = "openSForm()">Student</h1><h1 class = "lin">|</h1><h1 id = "faculty0" onclick = "openFForm()">Faculty</h1>
                      
                      <label class = "em" for="femail"><b>Email</b></label>
                      <input type="text" placeholder="Enter Email" name = "femail" required>

                      <label for = "fpsw"><b>Password</b></label>
                      <input type = "password" placeholder="Enter Password" name = "fpsw" required>
                  
                      <button type = "submit" name = "flogin" class = "btn">Login</button>
                      <button type = "button" class = "btn cancel" onclick = "closeForm()">Close</button>
                    </form>
                </div>
                <div class = "header-menu">
                    <ul>
                        <li><a href = #>Home</a></li>
                        <li><a href = #>Faculty</a></li>
                        <li><a href = #>Contact Us</a></li>
                        <li><a href = #>Feedback</a></li>
                        <li>&nbsp;</li>
                    </ul>
                </div>
            </div>
        </div>
        <img width = 100% style = "height: 100%;" class = "header-img" src = "header.jpg">
    </body>
</html>
