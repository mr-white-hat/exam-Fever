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
    if (isset($_GET['ques'])) {
        $ques = strval($_GET['ques']);
    }
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>exam-Fever</title>
        <link rel="icon" href="../icon.png">
        <link rel = "stylesheet" href = "profile.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src = "https://code.jquery.com/jquery-3.4.0.min.js"></script>
    </head>
    <body onload = "view_QP()">
        <div id = "web-container">
            <div class = "header">
                <div class = "M" onclick = "open_menu()">
                    <i class = "material-icons">menu</i>
                </div>
                <a href = #><img class = "logo" src = "../logo.png"></a>
                <button class = "logout-btn"><a href = "logout.php">Logout</a></button>
                <h2 class = "Nam"><?= $name ?></h2>
            </div>
            <img width = 100% id = "header-img" src = "welcome.jpg">
            <h3 id = "register" onclick = "view_class(this.id)" style = "display: none; color: gold; position: absolute; top: 13.5vh; right: 14.8vh; font-size: 26px; box-shadow: 0 2px 20px 2px white; background-color: black; padding: 10px; border-radius: 15px; cursor: pointer;">Exam Registration</h3>
            <div id="Display_php"><b>Person info will be listed here...</b></div>
        </div>
        <div id = "BLUR"></div>
        <div class = "navbar" id = "navbar">
            <p class = "blk">&nbsp;</p>
            <p class = "N"><?= '&nbsp Hi! '.$name ?></p>
            <ul>
                <li id = "usr-act" onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">person</i>Profile</li>
                <li onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">schedule</i>Ongoing</li>
                <div class = "drp" onmouseover = "mouseOver()" onmouseout = "mouseOut()">
                    <li onclick = "drop_down_menu()" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">work</i>Classes<span id = "down"><i class = "material-icons ico">keyboard_arrow_down</i></span></li>
                    <div id = "classes" style = "color: gold; cursor: pointer">
                        <?php
                            if ($result) {
                                while($row = mysqli_fetch_row($result)) {
                                    echo "<li id = '$row[0]' style = 'padding: 8px 0' onclick = 'view_class(this.id)'>".strtoupper($row[0])."</li>";
                                }
                            }
                        ?>
                    </div>
                </div>
                <li onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">done</i>Evaluation</li>
                <li onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">event</i>Schedule</li>
                <li onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">feedback</i>Feedbacks</li>
            </ul>
            <div class = "C" onclick = "close_menu()">
                <i class = "material-icons" onclick = "close_menu()">close</i>
            </div>
            </div>
        <script>
            function open_menu() {
                document.getElementById("navbar").style.display = "block";
                document.getElementById("BLUR").style.display = "block";
            }
            function close_menu() {
                document.getElementById("navbar").style.display = "none";
                document.getElementById("BLUR").style.display = "none";
            }
            $(document).mouseup(function (e) { 
                if ($(e.target).closest(".navbar").length === 0) { 
                    $(".navbar").hide(); 
                    $("#BLUR").hide();
                } 
            });
            function drop_down_menu() {
                var div = document.getElementById("classes");
                if (div.style.display == "block") {
                    div.style.display = "none";
                }
                else {
                    div.style.display = "block";
                }
            }
            function mouseOver() {
                document.getElementById('classes').style.display = "block";
            }
            function mouseOut() {
                document.getElementById('classes').style.display = "none";
            }
            function view_class(str) {
                if (str == "") {
                    document.getElementById("Display_php").innerHTML = "";
                    return;
                }
                else {
                    document.getElementById('header-img').src = "header.jpg";
                    document.getElementById("register").style.display = "none";
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("Display_php").innerHTML = this.responseText;
                        }
                    };
                    close_menu();
                    if (str == 'usr-act') {
                        xmlhttp.open("GET", "usr-act.php", true);
                        xmlhttp.send();
                    }
                    else if (str == 'ongoing') {
                        xmlhttp.open("GET", "ongoing.php", true);
                        xmlhttp.send();
                    }
                    else if (str == 'evaluation') {
                        xmlhttp.open("GET", "evaluation.php", true);
                        xmlhttp.send();
                    }
                    else if (str == 'schedule') {
                        xmlhttp.open("GET", "schedule.php", true);
                        xmlhttp.send();
                    }
                    else if (str == 'feedbacks') {
                        xmlhttp.open("GET", "feedbacks.php", true);
                        xmlhttp.send();
                    }
                    else if (str == 'register') {
                        xmlhttp.open("GET", "register.php?id=" + '<?php echo $id ?>', true);
                        xmlhttp.send();
                    }
                    else {
                        xmlhttp.open("GET", "class.php?q=" + str, true);
                        xmlhttp.send();
                        document.getElementById("register").style.display = "block";
                    }
                }
            }
            function view_paper(str) {
                window.location.replace("profile.php?ques=" + str);
            }
            function view_QP() {
                str = '<?php echo $ques ?>';
                if (str != "") {
                    document.getElementById('header-img').src = "header.jpg";
                    document.getElementById("register").style.display = "none";
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("Display_php").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "questionpaper.php?id=" + str, true);
                    xmlhttp.send();
                }
            }
            function edit_ques(str) {
                if (str == "") {
                    document.getElementById("Display_php").innerHTML = "";
                    return;
                }
                else {
                    document.getElementById("register").style.display = "none";
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("Display_php").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "editquestion.php?ques=" + '<?php echo $ques ?>&q=' + str, true);
                    xmlhttp.send();
                }
            }
            function Create_MCQ() {
                document.getElementById("MCQ_Q").style.display = "block";
                document.getElementById("TF_Q").style.display = "none";
                document.getElementById("OW_Q").style.display = "none";
                document.getElementById("LT_Q").style.display = "none";
                document.getElementById("MCQ_S").style.display = "block";
                document.getElementById("TF_S").style.display = "none";
                document.getElementById("OW_S").style.display = "none";
                document.getElementById("LT_S").style.display = "none";
            }
            function Create_TF() {
                document.getElementById("MCQ_Q").style.display = "none";
                document.getElementById("TF_Q").style.display = "block";
                document.getElementById("OW_Q").style.display = "none";
                document.getElementById("LT_Q").style.display = "none";
                document.getElementById("MCQ_S").style.display = "none";
                document.getElementById("TF_S").style.display = "block";
                document.getElementById("OW_S").style.display = "none";
                document.getElementById("LT_S").style.display = "none";
            }
            function Create_OW() {
                document.getElementById("MCQ_Q").style.display = "none";
                document.getElementById("TF_Q").style.display = "none";
                document.getElementById("OW_Q").style.display = "block";
                document.getElementById("LT_Q").style.display = "none";
                document.getElementById("MCQ_S").style.display = "none";
                document.getElementById("TF_S").style.display = "none";
                document.getElementById("OW_S").style.display = "block";
                document.getElementById("LT_S").style.display = "none";
            }
            function Create_LT() {
                document.getElementById("MCQ_Q").style.display = "none";
                document.getElementById("TF_Q").style.display = "none";
                document.getElementById("OW_Q").style.display = "none";
                document.getElementById("LT_Q").style.display = "block";
                document.getElementById("MCQ_S").style.display = "none";
                document.getElementById("TF_S").style.display = "none";
                document.getElementById("OW_S").style.display = "none";
                document.getElementById("LT_S").style.display = "block";
            }
        </script>
    </body>
</html>