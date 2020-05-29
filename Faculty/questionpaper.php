<?php
    session_start();
    if (isset($_GET['id'])) {
        $id = strval($_GET['id']);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = strval($_POST['id']);
        $mysqli = new mysqli('localhost', 'root', '') or die($mysqli->error);
        $mysqli->query(
            "CREATE TABLE IF NOT EXISTS `responses`.`$id`
            (
                `sno` int(11) NOT NULL AUTO_INCREMENT,
                `reg` varchar(13) NOT NULL,
                `type` varchar(100) NOT NULL DEFAULT '',
                `qhash` varchar(32) NOT NULL,
                `response` text NOT NULL DEFAULT '',
                `marks` varchar(10) NOT NULL DEFAULT '',
                PRIMARY KEY (`sno`)
            )DEFAULT CHARSET = utf8;"
        ) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
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
                `marks` varchar(10) NOT NULL DEFAULT '',
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
            $marks = $mysqli->real_escape_string($_POST['marks1']);
            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash, option1, option2, option3, option4, correct, marks) VALUES ('MCQ', '$ques', '$qhash', '$option1', '$option2', '$option3', '$option4', '$correct', '$marks'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script>window.location.replace('profile.php?ques=$id');</script>";
        }
        elseif (isset($_POST['Submit_TF'])) {
            $ques = $mysqli->real_escape_string($_POST['Question2']);
            $qhash = $mysqli->real_escape_string(md5(rand(0,1000)));
            $correct = $mysqli->real_escape_string($_POST['TF']);
            $marks = $mysqli->real_escape_string($_POST['marks2']);
            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash, option1, option2, correct, marks) VALUES ('TF', '$ques', '$qhash', 'True', 'False', '$correct', '$marks'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script>window.location.replace('profile.php?ques=$id');</script>";
        }
        elseif (isset($_POST['Submit_OW'])) {
            $ques = $mysqli->real_escape_string($_POST['Question3']);
            $qhash = $mysqli->real_escape_string(md5(rand(0,1000)));
            $marks = $mysqli->real_escape_string($_POST['marks3']);
            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash, marks) VALUES ('OW', '$ques', '$qhash', '$marks'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script>window.location.replace('profile.php?ques=$id');</script>";
        }
        elseif (isset($_POST['Submit_LT'])) {
            $ques = $mysqli->real_escape_string($_POST['Question4']);
            $qhash = $mysqli->real_escape_string(md5(rand(0,1000)));
            $marks = $mysqli->real_escape_string($_POST['marks4']);
            $sql = "INSERT INTO `questionpaper`.`$id`(type, ques, qhash, marks) VALUES ('LT', '$ques', '$qhash', '$marks'); ";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            echo "<script>window.location.replace('profile.php?ques=$id');</script>";
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
                border: 1px solid #ccc;
                cursor: pointer;
            }
            .dropbtn:hover {
                background-color: goldenrod;
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
                margin-bottom: 10px;
            }
            #createQ {
                margin-top: 120px;
                margin-left: 50px;
            }
            #dis {
                width: 100%;
                background-color: black;
                box-shadow: 0px 8px 16px 0px white;
                border-radius: 30px;
                padding: 30px;
            }
            #ques_tion {
                padding: 10px 0;
            }
            .edz {
                margin-top: 8px;
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
        </script>
    </head>
    <body>
        <h1>Question Paper</h1>
        <div class="dropdown">
            <button class="dropbtn">Add a Question</button>
            <div class="dropdown-content">
                <p id = "MCQ" onclick = "Create_MCQ()">MCQ</p>
                <p id = "TF" onclick = "Create_TF()">True or False</p>
                <p id = "OW" onclick = "Create_OW()">Short Text</p>
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
                        if (mysqli_num_rows($result) > 0) {
                            echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>Multiple Choice Questions:</p>";
                            while($row = mysqli_fetch_array($result)) {
                                $hsh = $row['qhash'];
                                echo "<div id = 'ques_tion' style = 'color: gold;'><p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option1']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option2']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option3']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option4']."</p><p class = 'crt' style = 'color: white;'>Correct answer:- ".$row['correct']."<p class = 'edz' id = '$hsh' onclick = 'edit_ques(this.id)' style = 'cursor: pointer; font-weight: bold; float: right;'>Edit Question-$count</p></div><hr style = 'border-top: 1px dashed gold;'>";
                                $count ++;
                            }
                        } 
                    }
                    $sql = "SELECT * FROM $id WHERE type = 'TF'";
                    if ($result = mysqli_query($mysqli, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>True or False:</p>";
                            while($row = mysqli_fetch_array($result)) {
                                $hsh = $row['qhash'];
                                echo "<div id = 'ques_tion' style = 'color: gold;'><p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option1']."</p><p class = 'Opt'><input type = 'radio' name = '$count'></input>".$row['option2']."</p><p class = 'crt' style = 'color: white;'>Correct answer:- ".$row['correct']."<p class = 'edz' id = '$hsh' onclick = 'edit_ques(this.id)' style = 'cursor: pointer; font-weight: bold; float: right;'>Edit Question-$count</p></div><hr style = 'border-top: 1px dashed gold;'>";
                                $count ++;
                            }
                        } 
                    }
                    $sql = "SELECT * FROM $id WHERE type = 'OW'";
                    if ($result = mysqli_query($mysqli, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>Short Answers:</p>";
                            while($row = mysqli_fetch_array($result)) {
                                $hsh = $row['qhash'];
                                echo "<div id = 'ques_tion' style = 'color: gold;'><p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p><p class = 'edz' id = '$hsh' onclick = 'edit_ques(this.id)' style = 'cursor: pointer; font-weight: bold; float: right;'>Edit Question-$count</p></div><hr style = 'border-top: 1px dashed gold;'>";
                                $count ++;
                            }
                        } 
                    }
                    $sql = "SELECT * FROM $id WHERE type = 'LT'";
                    if ($result = mysqli_query($mysqli, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>Long Answers:</p>";
                            while($row = mysqli_fetch_array($result)) {
                                $hsh = $row['qhash'];
                                echo "<div id = 'ques_tion' style = 'color: gold;'><p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p><p class = 'edz' id = '$hsh' onclick = 'edit_ques(this.id)' style = 'cursor: pointer; font-weight: bold; float: right;'>Edit Question-$count</p></div><hr style = 'border-top: 1px dashed gold;'>";
                                $count ++;
                            }
                        } 
                    }
                    if ($count == 1) {
                        echo "<div id = 'ques_tion' style = 'color: gold; font-size: 24px; text-align: center;'> No Questions added!!!</div>";
                    }
                ?>
            </div>
            <button class="dropbtn" type = "submit" name = "Submit_Ques" onclick = "window.location.href = 'profile.php?ques='" style = "margin: 30px; position: absolute; left: 35%">Finish Question Paper</button>
            <form action = "questionpaper.php" enctype = "multipart/form-data" method = "POST">
                <div id = "CreateQ">
                    <input type = "radio" name = 'id' style = "display: none;" checked = "True" value = <?php echo $id ?>></input>
                    <div id = "MCQ_Q" style = "display: none">
                        <input name = 'Question1' type = 'text' placeholder = 'Enter the question (MCQ)...'></input><br>
                        <input name = 'option1' type = 'text' placeholder = 'Option 1'></input><br>
                        <input name = 'option2' type = 'text' placeholder = 'Option 2'></input><br>
                        <input name = 'option3' type = 'text' placeholder = 'Option 3'></input><br>
                        <input name = 'option4' type = 'text' placeholder = 'Option 4'></input><br>
                        <input name = "correct" type = 'text' placeholder = 'Correct answer...'></input><br>
                        <input name = "marks1" type = 'text' placeholder = 'Marks...'></input>
                    </div>
                    <div id = "TF_Q" style = "display: none">
                        <input name = 'Question2' type = 'text' placeholder = 'Enter the question (True or False)...'></input><br>
                        <input type = 'radio' name = 'TF' value = "True"><span style = "color: gold; font-weight: bold; font-size: 24px;">True</span></input><br>
                        <input type = 'radio' name = 'TF' value = "False"><span style = "color: gold; font-weight: bold; font-size: 24px">False</span></input><br>
                        <input name = "marks2" type = 'text' placeholder = 'Marks...'></input>
                    </div>
                    <div id = "OW_Q" style = "display: none">
                        <input name = 'Question3' type = 'text' placeholder = 'Enter the question (Short Text)...'></input><br>
                        <input name = "marks3" type = 'text' placeholder = 'Marks...'></input>
                    </div>
                    <div id = "LT_Q" style = "display: none">
                        <input name = 'Question4' type = 'text' placeholder = 'Enter the question (Long Text)...'></input><br>
                        <input name = "marks4" type = 'text' placeholder = 'Marks...'></input>
                    </div>
                    <button id = "MCQ_S" class = "dropbtn" type = "submit" name = "Submit_MCQ" style = "display: none; position: absolute; margin-top: 10px; left: 40%">Add this Question</button>
                    <button id = "TF_S" class = "dropbtn" type = "submit" name = "Submit_TF" style = "display: none; position: absolute; margin-top: 10px; left: 40%">Add this Question</button>
                    <button id = "OW_S" class = "dropbtn" type = "submit" name = "Submit_OW" style = "display: none; position: absolute; margin-top: 10px; left: 40%">Add this Question</button>
                    <button id = "LT_S" class = "dropbtn" type = "submit" name = "Submit_LT" style = "display: none; position: absolute; margin-top: 10px; left: 40%">Add this Question</button>
                </div>
            </form>
        </div>
    </body>
</html>