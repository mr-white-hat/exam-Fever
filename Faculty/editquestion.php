<?php
    if (isset($_GET['ques'])) {
        $ques = strval($_GET['ques']);
    }
    if (isset($_GET['q'])) {
        $q = strval($_GET['q']);
    }
    $mysqli = new mysqli ('localhost', 'root', '', 'questionpaper');
    $sql = "SELECT * FROM $ques WHERE qhash = '$q'";
    echo '<h1>Modify the Question</h1>';
    if ($result = mysqli_query($mysqli, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                if  ($row['type'] == 'MCQ') {
                    $sno = $row['sno'];
                    $Q = $row['ques'];
                    $Op1 = $row['option1'];
                    $Op2 = $row['option2'];
                    $Op3 = $row['option3'];
                    $Op4 = $row['option4'];
                    $CA = $row['correct'];
                    $ms = $row['marks'];
                    // echo $Q, $Op1, $Op2, $Op3, $Op4, $CA;
                    echo '<div id = "show"><form action = "editquestion.php?ques='.$ques.'&q='.$q.'" enctype = "multipart/form-data" method = "POST">
                    <input type = "text" style = "display: none;" name = "sno" value = "'.$sno.'"</input>
                    <input name = "Question" type = "text" placeholder = "Enter the question (MCQ)..." value = "'.$Q.'"></input><br>
                    <input name = "option1" type = "text" placeholder = "Option 1" value = "'.$Op1.'"></input><br>
                    <input name = "option2" type = "text" placeholder = "Option 2" value = "'.$Op2.'"></input><br>
                    <input name = "option3" type = "text" placeholder = "Option 3" value = "'.$Op3.'"></input><br>
                    <input name = "option4" type = "text" placeholder = "Option 4" value = "'.$Op4.'"></input><br>
                    <input name = "correct" type = "text" placeholder = "Correct answer..." value = "'.$CA.'"></input><br>
                    <input name = "marks1" type = "text" placeholder = "Marks..."></input>
                    <button class = "dropbtn" type = "submit" name = "Delete" style = "margin-top: 10px; float: left;">Delete this Question</button>
                    <button id = "MCQ_S" class = "dropbtn" type = "submit" name = "Submit_MCQ" style = "margin-top: 10px; float: right;">Update this Question</button></form></div>';
                    echo '<script>window.location.replace("profile.php?ques='.$ques.'")</script>';
                }
                elseif ($row['type'] == 'TF') {
                    $sno = $row['sno'];
                    $Q = $row['ques'];
                    $CA = $row['correct'];
                    echo '<div id = "show"><form action = "editquestion.php?ques='.$ques.'&q='.$q.'" enctype = "multipart/form-data" method = "POST">
                    <input type = "text" style = "display: none;" name = "sno" value = "'.$sno.'"</input>
                    <input name = "Question" type = "text" placeholder = "Enter the question (True or False)..." value = "'.$Q.'"></input><br>
                    <input type = "radio" name = "TF" value = "True"><span style = "color: gold; font-weight: bold; font-size: 24px;">True</span></input><br>
                    <input type = "radio" name = "TF" value = "False"><span style = "color: gold; font-weight: bold; font-size: 24px">False</span></input><br>
                    <input name = "correct" type = "text" placeholder = "Correct answer..." value = "'.$CA.'"></input><br>
                    <input name = "marks2" type = "text" placeholder = "Marks..."></input>
                    <button class = "dropbtn" type = "submit" name = "Delete" style = "margin-top: 10px; float: left;">Delete this Question</button>
                    <button id = "TF_S" class = "dropbtn" type = "submit" name = "Submit_TF" style = "margin-top: 10px; float: right;">Update this Question</button></form></div>';
                    echo '<script>window.location.replace("profile.php?ques='.$ques.'")</script>';
                }
                elseif ($row['type'] == 'OW') {
                    $sno = $row['sno'];
                    $Q = $row['ques'];
                    echo '<div id = "show"><form action = "editquestion.php?ques='.$ques.'&q='.$q.'" enctype = "multipart/form-data" method = "POST">
                    <input type = "text" style = "display: none;" name = "sno" value = "'.$sno.'"</input>
                    <input name = "Question" type = "text" placeholder = "Enter the question (MCQ)..." value = "'.$Q.'"></input><br>
                    <input name = "marks3" type = "text" placeholder = "Marks..."></input>
                    <button class = "dropbtn" type = "submit" name = "Delete" style = "margin-top: 10px; float: left;">Delete this Question</button>
                    <button id = "OW_S" class = "dropbtn" type = "submit" name = "Submit_OW" style = "margin-top: 10px; float: right;">Update this Question</button></form></div>';
                    echo '<script>window.location.replace("profile.php?ques='.$ques.'")</script>';
                }
                elseif ($row['type'] == 'LT') {
                    $sno = $row['sno'];
                    $Q = $row['ques'];
                    echo '<div id = "show"><form action = "editquestion.php?ques='.$ques.'&q='.$q.'" enctype = "multipart/form-data" method = "POST">
                    <input type = "text" style = "display: none;" name = "sno" value = "'.$sno.'"</input>
                    <input name = "Question" type = "text" placeholder = "Enter the question (MCQ)..." value = "'.$Q.'"></input><br>
                    <input name = "marks4" type = "text" placeholder = "Marks..."></input>
                    <button class = "dropbtn" type = "submit" name = "Delete" style = "margin-top: 10px; float: left;">Delete this Question</button>
                    <button id = "LT_S" class = "dropbtn" type = "submit" name = "Submit_LT" style = "margin-top: 10px; float: right;">Update this Question</button></form></div>';
                    echo '<script>window.location.replace("profile.php?ques='.$ques.'")</script>';
                }
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['Delete'])){
            $sno = intval($mysqli->real_escape_string($_POST['sno']));
            $mysqli = new mysqli ('localhost', 'root', '', 'questionpaper');
            $sql = "DELETE FROM `$ques`WHERE `$ques`.`sno` = $sno";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
        }
        elseif (isset($_POST['Submit_MCQ'])) {
            $sno = intval($mysqli->real_escape_string($_POST['sno']));
            $que = $mysqli->real_escape_string($_POST['Question']);
            $option1 = $mysqli->real_escape_string($_POST['option1']);
            $option2 = $mysqli->real_escape_string($_POST['option2']);
            $option3 = $mysqli->real_escape_string($_POST['option3']);
            $option4 = $mysqli->real_escape_string($_POST['option4']);
            $correct = $mysqli->real_escape_string($_POST['correct']);
            $marks = $mysqli->real_escape_string($_POST['marks1']);
            $mysqli = new mysqli ('localhost', 'root', '', 'questionpaper');
            $sql = "UPDATE `$ques` SET `ques` = '$que', `option1` = '$option1', `option2` = '$option2', `option3` = '$option3', `option4` = '$option4', `correct` = '$correct', `marks` = '$marks' WHERE `$ques`.`sno` = $sno";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
        }
        elseif (isset($_POST['Submit_TF'])) {
            $sno = intval($mysqli->real_escape_string($_POST['sno']));
            $que = $mysqli->real_escape_string($_POST['Question']);
            $correct = $mysqli->real_escape_string($_POST['correct']);
            $marks = $mysqli->real_escape_string($_POST['marks2']);
            $mysqli = new mysqli ('localhost', 'root', '', 'questionpaper');
            $sql = "UPDATE `$ques` SET `ques` = '$que', `correct` = '$correct', `marks` = '$marks' WHERE `$ques`.`sno` = $sno";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
        }
        elseif (isset($_POST['Submit_OW'])) {
            $sno = intval($mysqli->real_escape_string($_POST['sno']));
            $que = $mysqli->real_escape_string($_POST['Question']);
            $marks = $mysqli->real_escape_string($_POST['marks3']);
            $mysqli = new mysqli ('localhost', 'root', '', 'questionpaper');
            $sql = "UPDATE `$ques` SET `ques` = '$que', `marks` = '$marks' WHERE `$ques`.`sno` = $sno";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
        }
        elseif (isset($_POST['Submit_LT'])) {
            $sno = intval($mysqli->real_escape_string($_POST['sno']));
            $que = $mysqli->real_escape_string($_POST['Question']);
            $marks = $mysqli->real_escape_string($_POST['marks4']);
            $mysqli = new mysqli ('localhost', 'root', '', 'questionpaper');
            $sql = "UPDATE `$ques` SET `ques` = '$que', `marks` = '$marks' WHERE `$ques`.`sno` = $sno";
            mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
        }
    }
?>
<html>
    <head>
        <style>
            h1 {
                color: gold;
                width: 50%;
                position: absolute;
                top: 18vh;
                left: 68vh;
                font-size: 53px;
            }
            #show {
                font-weight: bold;
                width: 50%;
                position: absolute;
                top: 35vh;
                left: 47vh;
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
        </style>
    </head>
</html>