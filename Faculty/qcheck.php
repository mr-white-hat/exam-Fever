<?php
    session_start();
    if (isset($_GET['id'])) {
        $id = strval($_GET['id']);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = strval($_POST['id']);
        $mysqli = new mysqli('localhost', 'root', '') or die($mysqli->error);
        $mysqli->query(
            "CREATE TABLE IF NOT EXISTS `questionpaper`.`$id`
            (
                `sno` int(11) NOT NULL AUTO_INCREMENT,
                `type` varchar(100) NOT NULL,
                `ques` text NOT NULL,
                `qhash` varchar(32) NOT NULL,
                `option1` text NOT NULL DEFAULT '',
                `option2` text NOT NULL DEFAULT '',
                `option3` text NOT NULL DEFAULT '',
                `option4` text NOT NULL DEFAULT '',
                `correct` text NOT NULL DEFAULT '',
                PRIMARY KEY (`sno`)
            )DEFAULT CHARSET = utf8;"
        );
        if (isset($_POST['Submit_MCQ'])) {
            $qhash = $mysqli->real_escape_string(md5(rand(0,1000)));
            $ques = $mysqli->real_escape_string($_POST['Question1']);
            $option1 = $mysqli->real_escape_string($_POST['option1']);
            $option2 = $mysqli->real_escape_string($_POST['option2']);
            $option3 = $mysqli->real_escape_string($_POST['option3']);
            $option4 = $mysqli->real_escape_string($_POST['option4']);
            $correct = $mysqli->real_escape_string($_POST['correct']);
            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash, option1, option2, option3, option4, correct) VALUES ('MCQ', '$ques', '$qhash', '$option1', '$option2', '$option3', '$option4', '$correct'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script type='text/javascript>view_paper('$id');</script>";
        }
        elseif (isset($_POST['Submit_TF'])) {
            $ques = $mysqli->real_escape_string($_POST['Question2']);
            $qhash = $mysqli->real_escape_string(md5(rand(0,1000)));
            $correct = $mysqli->real_escape_string($_POST['TF']);
            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash, option1, option2, correct) VALUES ('TF', '$ques', '$qhash', 'True', 'False', '$correct'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script type='text/javascript>view_paper('$id');</script>";
        }
        elseif (isset($_POST['Submit_OW'])) {
            $ques = $mysqli->real_escape_string($_POST['Question3']);
            $qhash = $mysqli->real_escape_string(md5(rand(0,1000)));

            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash) VALUES ('OW', '$ques', '$qhash'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script type='text/javascript>view_paper({$id});</script>";
        }
        elseif (isset($_POST['Submit_LT'])) {
            $ques = $mysqli->real_escape_string($_POST['Question4']);
            $qhash = $mysqli->real_escape_string(md5(rand(0,1000)));
            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash) VALUES ('LT', '$ques', '$qhash'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script type='text/javascript>view_paper('$id');</script>";
        }
    }
?>
<html>
    <head>
        <title>Question Paper</title>
        <link rel = "icon" href = "icon.png">
        <style>
            h1 {
                color: gold;
                width: 50%;
                position: absolute;
                top: 18vh;
                left: 82vh;
                font-size: 53px;
            }
            .show {
                font-weight: bold;
                width: 50%;
                position: absolute;
                top: 35vh;
                left: 47vh;
            }
            .dropbtn {
                background-color: gold;
                color: black;
                padding: 21px;
                font-size: 16px;
                border: none;
                font-weight: bold;
                border-radius: 30px;
            }
            .dropdown {
                display: inline-block;
                font-weight: bold;
                position: fixed;
                top: 35vh;
                right: 20vh;
            }
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: black;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px white;
                z-index: 1;
                cursor: pointer;
            }
            .dropdown-content p {
                color: gold;
                padding: 6px 16px;
                text-decoration: none;
                display: block;
                cursor: pointer;
            }
            .dropdown-content a:hover {
                background-color: #f1f1f1
            }
            .dropdown:hover .dropdown-content {
                display: block;
            }
            .dropdown:hover .dropbtn {
                background-color: goldenrod;
            }
            input[type = text] {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                resize: vertical;
                background-color: gold;
                color: black;
                font-weight: bold;
                border-radius: 30px;
                border-width: 2px;
                border-style: inset;
                border-color: initial;
                border-image: initial;
            }
            #dis {
                width: 100%;
                background-color: black;
                box-shadow: 0px 8px 16px 0px white;
                border-radius: 30px;
                padding: 30px;
            }
            #ques_tion {
                padding-top: 5px;
            }
        </style>
        <script>
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
            function view_paper(str) {
                if (str == "") {
                    document.getElementById("Display_php").innerHTML = "";
                    return;
                }
                else {
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
        </script>
    </head>
    <body>
        <h1>Question Paper</h1>
        <div class="dropdown">
            <button class="dropbtn">Add a Question</button>
            <div class="dropdown-content">
                <p id = "MCQ" onclick = "Create_MCQ()">MCQ</p>
                <p id = "TF" onclick = "Create_TF()">True or False</p>
                <p id = "OW" onclick = "Create_OW()">One word</p>
                <p id = "LT" onclick = "Create_LT()">Long Text</p>
            </div>
        </div>
        <div class = "show">
            <div id = "dis">
                <?php
                    $count = 1;
                    $mysqli = new mysqli('localhost', 'root', '', 'questionpaper') or die($mysqli->error);
                    $sql = "SELECT * FROM $id WHERE type = 'MCQ'";
                    if ($result = mysqli_query($mysqli, $sql)) {
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)) {
                                echo "<div id = 'ques_tion' style = 'color: gold;'><p class = 'Ques'>".$count.". ".$row['ques']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option1']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option2']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option3']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option4']."</p><p class = 'crt' style = 'color: white;'>Correct answer:- ".$row['correct']."</div>";
                                $count ++;
                            }
                        }
                    }
                    else {
                        echo "<div id = 'ques_tion' style = 'color: gold; font-size: 24px; text-align: center;'> No Questions added!!!</div>";
                    }
                ?>
            </div>
            <form action = "qcheck.php" enctype = "multipart/form-data" method = "POST">
                <div id = "CreateQ">
                    <input type = "radio" name = 'id' style = "display: none;" checked = "True" value = <?php echo $id ?>></input>
                    <div id = "MCQ_Q" style = "display: none">
                        <input name = 'Question1' type = 'text' placeholder = 'Enter the question...'></input><br>
                        <input name = 'option1' type = 'text' placeholder = 'Option 1'></input><br>
                        <input name = 'option2' type = 'text' placeholder = 'Option 2'></input><br>
                        <input name = 'option3' type = 'text' placeholder = 'Option 3'></input><br>
                        <input name = 'option4' type = 'text' placeholder = 'Option 4'></input><br>
                        <input name = "correct" type = 'text' placeholder = 'Correct answer...'></input>
                    </div>
                    <div id = "TF_Q" style = "display: none">
                        <input name = 'Question2' type = 'text' placeholder = 'Enter the question...'></input><br>
                        <input type = 'radio' name = 'TF' value = "True"><span style = "color: gold;">True</span></input><br>
                        <input type = 'radio' name = 'TF' value = "False"><span style = "color: gold;">False</span></input><br>
                    </div>
                    <div id = "OW_Q" style = "display: none">
                        <input name = 'Question3' type = 'text' placeholder = 'Enter the question...'></input><br>
                    </div>
                    <div id = "LT_Q" style = "display: none">
                        <input name = 'Question4' type = 'text' placeholder = 'Enter the question...'></input>
                    </div>
                    <button id = "MCQ_S" class="dropbtn" type = "submit" name = "Submit_MCQ" style = "display: none">Add this Question</button>
                    <button id = "TF_S" class="dropbtn" type = "submit" name = "Submit_TF" style = "display: none">Add this Question</button>
                    <button id = "OW_S" class="dropbtn" type = "submit" name = "Submit_OW" style = "display: none">Add this Question</button>
                    <button id = "LT_S" class="dropbtn" type = "submit" name = "Submit_LT" style = "display: none">Add this Question</button>
                </div>
            </form>
        </div>
    </body>
</html>