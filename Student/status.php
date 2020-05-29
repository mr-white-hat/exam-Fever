<?php
    session_start();
    if (isset($_GET['ques'])) {
        $Qid = strval($_GET['ques']);
    }
    $sec = $_SESSION['sec'];
    $reg = $_SESSION['regno'];
    $mysqli = new mysqli('localhost', 'root', '') or die($mysqli->error);
    $sql = "SHOW DATABASES";
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        while($rows = mysqli_fetch_array($result)) {
            $mysqli = new mysqli('localhost', 'root', '', $rows[0]) or die($mysqli->error);
            $sql = "SELECT * FROM `$sec` WHERE hash = '$Qid'";
            if($resulT = mysqli_query($mysqli, $sql)){
                if(mysqli_num_rows($resulT) > 0){
                    while($row = mysqli_fetch_array($resulT)){
                        $ET = $row['etime'];
                        $name = $row['name'];
                        $_SESSION['exam'] = $name;
                    }
                }
            }
            $mysqli = new mysqli('localhost', 'root', '', 'responses') or die($mysqli->error);
            $sql = "SELECT * FROM `$Qid` WHERE reg = '$reg'";
            if($resulT = mysqli_query($mysqli, $sql)){
                if(mysqli_num_rows($resulT) > 0){
                    header("Location: response.php?ques=$Qid");
                }
            }
        }
    }
?>
<html>
    <head>
        <title>Status</title>
        <link rel = "icon" href = "icon.png">
        <style>
            body {
                background-color: black;
            }
            .form{
                margin-block-end: 0;
                margin-block-start: 0;
                scroll-margin-block: 0;
                box-shadow: 0 15px 30px 0 grey;
                width: 350px;
                margin: auto;
                border: 3px solid black;
                z-index: 9;
                border-radius: 18.3px;
                padding: 10px;
                background-color: gold;
                border-radius: 15px;
                text-align: center;
            }
            p {
                font-weight: bold;
            }
            #home {
                padding: 10px 30px;
                color: white;
                background-color: black;
                cursor: pointer;
                text-decoration: None;
                margin-bottom: 500px;
            }
        </style>
        <script>
            // var counter = 3;
            // setInterval(function() {
            // counter--;
            // document.getElementById("count").innerHTML = counter;
            // }, 1000);
            function check_T() {
                str = '<?php echo $Qid ?>';
                d = '<?php echo $ET ?>';
                if (str != '') {
                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    // var dateTime = date+' '+time;
                    // document.write(d);
                    // document.write(time);
                    if (d >= time) {
                        window.location.replace("qpaper.php?ques=" + str);
                    }
                    else {
                        window.location.replace("response.php?ques=" + str);
                    }
                }
            }
        </script>
    </head>
    <body onload = "check_T()" id = "show">
        <div class = "form">
            <h1>Exam Status</h1>
            <h3><?= $name ?></h3>
            <p> Loading... </p>
        </div>
    </body>
</html>