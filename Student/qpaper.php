<?php
    session_start();
    $name = $_SESSION['name'];
    if (isset($_GET['ques'])) {
        $Quest = strval($_GET['ques']);
        $_SESSION['pap'] = $Quest;
    }
    $exam = $_SESSION['exam'];
    $sec = $_SESSION['sec'];
    $reg = $_SESSION['regno'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['Submit_Response'])) {
            $Quest = $_SESSION['pap'];
            $check = $_SESSION['check'];
            $mysqli = new mysqli('localhost', 'root', '') or die($mysqli->error);
            $mysqli->query(
                "CREATE TABLE IF NOT EXISTS `responses`.`$Quest`
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
            $mysqli = new mysqli('localhost', 'root', '', 'responses') or die($mysqli->error);
            $arraylength = count($check);
            foreach ($check as $x) {
                // $ddd = "'".$ddd."'";
                // $x = strval($x);
                // array_push($check, $x);
                // print_r($check);
                $response = $mysqli->real_escape_string($_POST[$x]);
                $sql = "INSERT INTO `responses`.`$Quest`(reg, qhash, response) VALUES ('$reg', '$x', '$response'); ";
                mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
            }
            header("Location: attempt.php");
        }
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
        <style>
            h1 {
                color: gold;
                width: 50%;
                position: absolute;
                top: 18vh;
                left: 42%;
                font-size: 53px;
            }
            #show {
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
            .Ques {
                font-size: 20px;
            }
            .container {
                display: block;
                position: relative;
                padding-left: 35px;
                margin-bottom: 12px;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .container input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
            }
            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 17px;
                width: 17px;
                background-color: #eee;
                border-radius: 50%;
            }
            .container:hover input ~ .checkmark {
                background-color: #ccc;
            }
            .container input:checked ~ .checkmark {
                background-color: gold;
            }
            .checkmark:after {
                content: "";
                position: absolute;
                display: none;
            }
            .container input:checked ~ .checkmark:after {
                display: block;
            }
            .container .checkmark:after {
                top: 5px;
                left: 5px;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: white;
            }
        </style>
    </head>
    <body>
        <div id = "web-container">
            <div class = "header">
                <div class = "M">
                    <i class = "material-icons">menu</i>
                </div>
                <a href = #><img class = "logo" src = "../logo.png"></a>
                <button class = "logout-btn"><a href = "logout.php">Logout</a></button>
                <h2 class = "Nam"><?= $name ?></h2>
            </div>
            <img width = 100% id = "header-img" src = "header.jpg">
        </div>
        <h1> <?= $exam ?> </h1>
        <div id = "show">
            <div id = "dis">
                <form action = "qpaper.php" enctype = "multipart/form-data" method = "POST">
                    <?php
                        $count = 1;
                        $check = array();
                        if (isset($_GET['ques'])) {
                            $mysqli = new mysqli ('localhost', 'root', '', 'questionpaper');
                            $sql = "SELECT * FROM $Quest WHERE type = 'MCQ'";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>Multiple Choice Questions:</p>";
                                    while($row = mysqli_fetch_array($result)) {
                                        $hsh = $row['qhash'];
                                        array_push($check, $hsh);
                                        $op1 = $row['option1'];
                                        $op2 = $row['option2'];
                                        $op3 = $row['option3'];
                                        $op4 = $row['option4'];
                                        echo "<div id = 'ques_tion' style = 'color: gold;'>
                                            <p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p>
                                            <label class='container'>".$row['option1']."
                                                <input type = 'radio' name = '$hsh' value = '$op1'>
                                                <span class = 'checkmark'></span>
                                            </label>
                                            <label class='container'>".$row['option2']."
                                                <input type = 'radio' name = '$hsh' value = '$op2'>
                                                <span class = 'checkmark'></span>
                                            </label>
                                            <label class='container'>".$row['option3']."
                                                <input type = 'radio' name = '$hsh' value = '$op3'>
                                                <span class = 'checkmark'></span>
                                            </label>
                                            <label class='container'>".$row['option4']."
                                                <input type = 'radio' name = '$hsh' value = '$op4'>
                                                <span class = 'checkmark'></span>
                                            </label>
                                        </div>
                                        <hr style = 'border-top: 1px dashed gold;'>";
                                        $count ++;
                                    }
                                } 
                            }
                            $sql = "SELECT * FROM $Quest WHERE type = 'TF'";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>True or False:</p>";
                                    while($row = mysqli_fetch_array($result)) {
                                        $hsh = $row['qhash'];
                                        array_push($check, $hsh);
                                        $op1 = $row['option1'];
                                        $op2 = $row['option2'];
                                        echo "<div id = 'ques_tion' style = 'color: gold;'>
                                        <p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p>
                                        <label class='container'>".$row['option1']."
                                            <input type = 'radio' name = '$hsh' value = '$op1'>
                                            <span class = 'checkmark'></span>
                                        </label>
                                        <label class='container'>".$row['option2']."
                                            <input type = 'radio' name = '$hsh' value = '$op2'>
                                            <span class = 'checkmark'></span>
                                        </label>
                                    </div>
                                    <hr style = 'border-top: 1px dashed gold;'>";
                                        $count ++;
                                    }
                                } 
                            }
                            $sql = "SELECT * FROM $Quest WHERE type = 'OW'";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>Short Answers:</p>";
                                    while($row = mysqli_fetch_array($result)) {
                                        $hsh = $row['qhash'];
                                        array_push($check, $hsh);
                                        echo "<div id = 'ques_tion' style = 'color: gold;'><p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p>
                                        <textarea name = '$hsh' rows = '5' cols = '100' style = 'background-color: goldenrod; color: black; font-weight: bold;' placeholder = 'Answer the Question...'></textarea></div><hr style = 'border-top: 1px dashed gold;'>";
                                        $count ++;
                                    }
                                } 
                            }
                            $sql = "SELECT * FROM $Quest WHERE type = 'LT'";
                            if ($result = mysqli_query($mysqli, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo "<p style = 'color: goldenrod; font-weight: bold; font-size: 26px;'>Long Answers:</p>";
                                    while($row = mysqli_fetch_array($result)) {
                                        $hsh = $row['qhash'];
                                        array_push($check, $hsh);
                                        echo "<div id = 'ques_tion' style = 'color: gold;'><p class = 'Ques'>Question No. ".$count." )&emsp; ".$row['ques']."<span style = 'color: white'> &emsp; ".$row['marks']." Marks</span></p>
                                        <textarea name = '$hsh' rows = '10' cols = '100' style = 'background-color: goldenrod; color: black; font-weight: bold;' placeholder = 'Answer the Question...'></textarea></div><hr style = 'border-top: 1px dashed gold;'>";
                                        $count ++;
                                    }
                                } 
                            }
                            $_SESSION['check'] = $check;
                        }
                        if ($count == 1) {
                            echo "<div id = 'ques_tion' style = 'color: gold; font-size: 24px; text-align: center;'>Question Paper Not Found!!!</div>";
                        }
                    ?>
                    <button class="dropbtn" type = "submit" name = "Submit_Response" style = "margin: 80px 0 80px 40px; position: absolute; left: 35%">Submit Response</button>
                </form>
            </div>
        </div>
    </body>
</html>