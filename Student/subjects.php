<?php
    session_start();
    if (isset($_GET['id'])) {
        $Fid = strval($_GET['id']);
    }
    $sec = $_SESSION['sec'];
    $mysql = new mysqli('localhost', 'root', '', 'exam-fever') or die($mysqli->error);
    $sql = "SELECT * FROM faculty WHERE id = '$Fid'";
    $details = mysqli_query($mysql, $sql);
    $user = $details->fetch_assoc();
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
                top: 20vh;
                left: 75vh;
                font-size: 71px;
            }
            #fac{
                color: white;
                position: absolute;
                top: 40vh;
                left: 50vh;
                font-size: 37px;
            }
            #show {
                position: absolute;
                top: 90vh;
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
        <h1>Subject details</h1>
        <?php
            echo "<div id = 'fac'>
                    Faculty ID &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$user['id']."<br>
                    Faculty Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$user['name']."<br>
                    Faculty Email &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$user['email']."<br>
                    Qualifation &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$user['qual']."<br>
                    Faculty DoJ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$user['djoin']." - Present<br>
                    Department Name &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$user['depart']."<br>
                    University Name &nbsp; &nbsp; : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ABC University, Heaven<br></div>"
        ?>
        <div id = "show">
            <?php
            $mysqli = new mysqli('localhost', 'root', '', $Fid) or die($mysqli->error);
            $sql = "SELECT * FROM `$sec`";
                if($result = mysqli_query($mysqli, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        $Fid = "$Fid";
                        echo "<table>";
                            echo "<tr>";
                                echo "<th>S.No</th>";
                                echo "<th>Exam Name</th>";
                                echo "<th>Exam Date</th>";
                                echo "<th>Start Time</th>";
                                echo "<th>End Time</th>";
                                echo "<th>Total Marks</th>";
                                echo "<th>Evaluation</th>";
                            echo "</tr>";
                        while($row = mysqli_fetch_array($result)){
                            $hash = $row['hash'];
                            $DT = '"'.$row['Edate'].' '.$row['stime'].'"';
                            echo "<tr id = '$hash' onclick = 'view_paper(this.id, $DT)' style = 'cursor: pointer; font-weight: bold;'>";
                                echo "<td>" . $row['sno'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                $date = explode('-',$row['Edate']);
                                echo "<td>" . $date[2].'/'.$date[1].'/'.$date[0] . "</td>";
                                echo "<td>" . $row['stime'] . "</td>";
                                echo "<td>" . $row['etime'] . "</td>";
                                echo "<td>" . $row['Tmarks'] . "</td>";
                                echo "<td>" . $row['eval'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        mysqli_free_result($result);
                    } else{
                        echo "<table>";
                            echo "<tr>";
                                echo "<th>S.No</th>";
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
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                }
            ?>
        </div>
    </body>
</html>