<?php
    session_start();
    if (isset($_GET['id'])) {
        $id = strval($_GET['id']);
        $mysqli = new mysqli('localhost', 'root', '', $id) or die($mysqli->error);
        $sql = "SHOW TABLES FROM $id";
        $result = mysqli_query($mysqli, $sql);
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
                left: 74vh;
                font-size: 53px;
            }
            #show {
                font-weight: bold;
                width: 50%;
                position: absolute;
                top: 35vh;
                left: 47vh;
            }
            input[type = text], select, input[type = date], input[type = time] {
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
            label {
                padding: 12px 12px 12px 0;
                display: inline-block;
                color: gold;
            }
            input[type = submit] {
                background-color: gold;
                color: black;
                padding: 15px 35px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 15px;
                font-weight: bold;
                border-radius: 30px;
                border-width: 2px;
                border-style: inset;
                border-color: initial;
                border-image: initial;
                position: absolute;
                left: 44%;
            }
            .container {
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
            }
            .col-25 {
                float: left;
                width: 25%;
                margin-top: 6px;
            }
            .col-75 {
                float: left;
                width: 75%;
                margin-top: 6px;
            }
            .row:after {
                content: "";
                display: table;
                clear: both;
            }
            .ttime::-webkit-datetime-edit-ampm-field {
                display: none;
            }
        </style>
        <script src= "https://code.jquery.com/jquery-3.4.0.min.js"> 
        </script> 
    </head>
    <body>
        <h1>Exam Registration</h1>
        <div id = "show">
            <form action = "register.php?id=<?php echo $id ?>" enctype="multipart/form-data" method="POST">
                <div class = "row">
                    <div class = "col-25">
                        <label for = "ename">Exam Name</label>
                    </div>
                    <div class = "col-75">
                        <input type = "text" id = "ename" name = "ename" placeholder = "Exam name.." required>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-25">
                        <label for = "sub">Subject Name</label>
                    </div>
                    <div class = "col-75">
                        <input type = "text" id = "sub" name = "sub" placeholder = "Subject name.." required>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-25">
                        <label for = "class">Class</label>
                    </div>
                    <div class = "col-75">
                        <select id = "class" name = "class" required>
                            <option value = "none" selected disabled hidden> Choose a Class </option> 
                            <?php
                            if ($result) {
                                while($row = mysqli_fetch_row($result)) {
                                    echo "<option id = '$row[0]' style = 'border-radius: 30px' value = '$row[0]'>".strtoupper($row[0])."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-25">
                        <label for = "edate">Exam Date</label>
                    </div>
                    <div class = "col-75">
                        <input type = "date" id = "edate" name = "edate" required>
                </div>
                </div>
                <div class = "row">
                    <div class = "col-25">
                        <label for = "starttime">Start Time</label>
                    </div>
                    <div class = "col-75">
                        <input type = "time" id = "starttime" name = "starttime" required>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-25">
                        <label for = "endtime">End Time</label>
                    </div>
                    <div class = "col-75">
                        <input type = "time" id = "endtime" name = "endtime" required>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-25">
                        <label for = "tmarks">Total Marks</label>
                    </div>
                    <div class = "col-75">
                        <input type = "text" id = "tmarks" name = "tmarks" placeholder = "Total marks.." required>
                    </div>
                </div>
                <div class = "row" style = "padding-top: 10px;">
                    <input type = "submit" value = "Submit">
                </div>
            </form>
        </div>
        <?php
            $_SESSION['message'] = '';
            $mysqli = new mysqli('localhost', 'root', '', $id) or die($mysqli->error);
            if ($_SERVER['REQUEST_METHOD'] =='POST') {
                $ename = $mysqli->real_escape_string($_POST['ename']);
                $sub = $mysqli->real_escape_string($_POST['sub']);
                $class = $mysqli->real_escape_string($_POST['class']);
                $edate = $mysqli->real_escape_string($_POST['edate']);
                $starttime = $mysqli->real_escape_string($_POST['starttime']);
                $endtime = $mysqli->real_escape_string($_POST['endtime']);
                $tmarks = $mysqli->real_escape_string($_POST['tmarks']);
                $hash = $mysqli->real_escape_string(md5(rand(0,1000)));
                $mysqli = new mysqli('localhost', 'root', '') or die($mysqli->error);
                $sql = 'CREATE DATABASE IF NOT EXISTS `$id`';
                // $mysqli = new mysqli('localhost', 'root', '', $id);
                $mysqli->query(
                    "CREATE TABLE IF NOT EXISTS `$id`.`$class` 
                    (
                        `sno` int(11) NOT NULL AUTO_INCREMENT,
                        `sub` varchar(100) NOT NULL,
                        `name` varchar(100) NOT NULL,
                        `Edate` date NOT NULL,
                        `stime` time NOT NULL,
                        `etime` time NOT NULL,
                        `Tmarks` varchar(100) NOT NULL,
                        `eval` varchar(100) NOT NULL DEFAULT 'Pending',
                        `hash` varchar(32) NOT NULL,
                        PRIMARY KEY (`sno`)
                    )DEFAULT CHARSET = utf8;"
                );
                $sql = "INSERT INTO `$id`.`$class`(sub, name, Edate, stime, etime, Tmarks, hash) VALUES ('$sub', '$ename', '$edate', '$starttime', '$endtime', '$tmarks', '$hash'); ";
                // mysqli_query($mysqli, $sql) or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
                if (mysqli_query($mysqli, $sql)) {
                    $_SESSION['message'] = 'Sccessfully registered Exam';
                    $mysqli = new mysqli('localhost', 'root', '', 'exams') or die($mysqli->error);
                    $mysqli->query(
                        "CREATE TABLE IF NOT EXISTS `exams`.`$hash` 
                        (
                            `sno` int(11) NOT NULL AUTO_INCREMENT,
                            `sub` varchar(100) NOT NULL,
                            `reg.no` varchar(13) NOT NULL,
                            `name` varchar(100) NOT NULL,
                            `marks` varchar(100) NOT NULL,
                            `eval` varchar(100) NOT NULL DEFAULT 'Pending',
                            PRIMARY KEY (`sno`)
                        )DEFAULT CHARSET = utf8;"
                    )  or die('MySQL Error: '.mysqli_error($mysqli).' ('.mysqli_errno($mysqli).')');
                    echo "<script>window.location.replace('exam_reg.php?id=$hash');</script>";
                }
                else {
                    $_SESSION['message'] = 'Exam Registration failed!';
                    echo "<script>window.location.replace('exam_reg.php');</script>";
                }
            }
        ?>
    </body>
</html>