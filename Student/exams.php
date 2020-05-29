<?php
    session_start();
    if (isset($_GET['sec'])) {
        $sec = strval($_GET['sec']);
    }
    $mysqli = new mysqli('localhost', 'root', '') or die($mysqli->error);
    $sql = "SHOW DATABASES";
    $result = mysqli_query($mysqli, $sql);
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <title>exam-Fever</title>
        <link rel="icon" href="../icon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src= 
            "https://code.jquery.com/jquery-3.4.0.min.js"> 
        </script>
        <style>
            h1 {
                color: gold;
                position: absolute;
                top: 14vh;
                left: 78vh;
                font-size: 71px;
            }
            #show {
                position: absolute;
                top: 35vh;
                left: 44vh;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 125vh;
            }
            th {
                background-color: gold;
                color: black;
                border: 3px solid white;
                text-align: center;
                padding: 8px;
            }
            td {
                text-align: center;
                padding: 8px;
                border: 2px solid gold;
            }
            tr:nth-child(odd) {
                background-color: black;
                color: white;
                border: 2px solid white;
            }
            tr:nth-child(even) {
                background-color: white;
                color: black;
                border: 2px solid black;
            }
        </style>
    </head>
    <body>
    <h1>Exam details</h1>
        <div id = "show">
            <?php
                if ($result) {
                    $count = 1;
                    echo "<table style = 'font-weight: bold;'>";
                            echo "<tr>";
                                echo "<th>S.No</th>";
                                echo "<th>Subject</th>";
                                echo "<th>Exam Name</th>";
                                echo "<th>Exam Date</th>";
                                echo "<th>Start Time</th>";
                                echo "<th>End Time</th>";
                                echo "<th>Total Marks</th>";
                                echo "<th>Evaluation</th>";
                            echo "</tr>";
                    while($rows = mysqli_fetch_array($result)) {
                        $mysqli = new mysqli('localhost', 'root', '', $rows[0]) or die($mysqli->error);
                        $sql = "SELECT * FROM `$sec`";
                        if($resulT = mysqli_query($mysqli, $sql)){
                            if(mysqli_num_rows($resulT) > 0){
                                while($row = mysqli_fetch_array($resulT)){
                                    $hash = $row['hash'];
                                    $DT = '"'.$row['Edate'].' '.$row['stime'].'"';
                                    echo "<tr id = '$hash' onclick = 'view_paper(this.id, $DT)' style = 'cursor: pointer; font-weight: bold;'>";
                                        echo "<td>" . $count . "</td>";
                                        echo "<td>" . $row['sub'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        $date = explode('-',$row['Edate']);
                                        echo "<td>" . $date[2].'/'.$date[1].'/'.$date[0] . "</td>";
                                        echo "<td>" . $row['stime'] . "</td>";
                                        echo "<td>" . $row['etime'] . "</td>";
                                        echo "<td>" . $row['Tmarks'] . "</td>";
                                        echo "<td>" . $row['eval'] . "</td>";
                                    echo "</tr>";
                                    $count += 1;
                                }
                                mysqli_free_result($resulT);
                            }
                            else {
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<th>S.No</th>";
                                        echo "<th>Subject</th>";
                                        echo "<th>Exam Name</th>";
                                        echo "<th>Exam Date</th>";
                                        echo "<th>Start Time</th>";
                                        echo "<th>End Time</th>";
                                        echo "<th>Total Marks</th>";
                                        echo "<th>Evaluation</th>";
                                    echo "</tr>";
                                    echo "<tr><td colspan = '7'> No records matching your query were found.</td></tr>";
                                echo "</table>";
                            }
                        }
                    }
                    echo "</table>";
                }
            ?>
        </div>
    </body>
</html>