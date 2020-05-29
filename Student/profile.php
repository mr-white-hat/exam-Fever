<?php
    session_start();
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $regno = $_SESSION['regno'];
    $year = $_SESSION['year'];
    $sec = $_SESSION['sec'];
    $mysqli = new mysqli('localhost', 'root', '') or die($mysqli->error);
    $sql = "SELECT table_schema as database_name FROM information_schema.tables WHERE table_type = 'base table' AND table_name = '$sec' ORDER BY table_schema";
    $result = $mysqli->query($sql);
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
        <script src= 
            "https://code.jquery.com/jquery-3.4.0.min.js"> 
        </script>
    </head>
    <body>
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
            <div id="Display_php"><b>Person info will be listed here...</b></div>
        </div>
        <div id = "BLUR"></div>
        <div class = "navbar" id = "navbar">
            <p class = "blk">&nbsp;</p>
            <p class = "N"><?= '&nbsp Hi! '.$name ?></p>
            <ul>
                <li id = "usr-act" onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">person</i>Profile</li>
                <li id = "exams" onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">library_books</i>Exams</li>
                <li onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">chrome_reader_mode</i>Marks</li>
                <li onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">event</i>Schedule</li>
                <div class = "drp" onmouseover = "mouseOver()" onmouseout = "mouseOut()">
                    <li onclick = "drop_down_menu()" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">list</i>Subjects<span id = "down" style = "position: absolute; left: 35vh; top: 40.9vh;cursor: pointer;"><i class = "material-icons ico">keyboard_arrow_down</i></span></li>
                    <div id = "subs" style = "color: gold; cursor: pointer; background-color: black; display: none; border-radius: 15px;">
                        <?php
                            if ($result) {
                                while($row = mysqli_fetch_row($result)) {
                                    $mysql = new mysqli('localhost', 'root', '', 'exam-fever') or die($mysqli->error);
                                    $fac = "SELECT * FROM faculty WHERE id = '$row[0]'";
                                    $resi = $mysql->query($fac);
                                    $sub = $resi->fetch_assoc();
                                    $Sdepart = $sub['depart'];
                                    $Fid = $sub['id'];
                                    echo "<li id = '$Fid' style = 'padding: 8px 0;' onclick = 'view_class(this.id)'>".strtoupper($Sdepart)."</li>";
                                }
                            }
                        ?>
                    </div>
                </div>
                <li onclick = "view_class(this.id)" style = "padding: 8px 16px; cursor: pointer;"><i class = "material-icons ico">feedback</i>Feedback</li>
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
                var div = document.getElementById("subs");
                if (div.style.display == "block") {
                    div.style.display = "none";
                }
                else {
                    div.style.display = "block";
                }
            }
            function mouseOver() {
                document.getElementById('subs').style.display = "block";
            }
            function mouseOut() {
                document.getElementById('subs').style.display = "none";
            }
            function view_class(str) {
                if (str == "") {
                    document.getElementById("Display_php").innerHTML = "";
                    return;
                }
                else {
                    document.getElementById('header-img').src = "header.jpg";
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
                    else if (str == 'exams') {
                        xmlhttp.open("GET", "exams.php?sec=" + '<?php echo $sec ?>', true);
                        xmlhttp.send();
                    }
                    else if (str == 'marks') {
                        xmlhttp.open("GET", "marks.php", true);
                        xmlhttp.send();
                    }
                    else if (str == 'schedule') {
                        xmlhttp.open("GET", "schedule.php", true);
                        xmlhttp.send();
                    }
                    else if (str == 'feedback') {
                        xmlhttp.open("GET", "feedback.php", true);
                        xmlhttp.send();
                    }
                    else {
                        xmlhttp.open("GET", "subjects.php?id=" + str, true);
                        xmlhttp.send();
                    }
                }
            }
            function view_paper(str, d) {
                window.location.replace("status.php?ques=" + str);
            }
        </script>
    </body>
</html>