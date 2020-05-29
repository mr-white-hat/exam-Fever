<?php
    session_start();
    if (isset($_GET['q'])) {
        $q = strval($_GET['q']);
    }
    $id = $_SESSION['id'];
    $mysqli = new mysqli('localhost', 'root', '', $id) or die($mysqli->error);
    $sql = "SELECT * FROM `$q`";
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
                top: 16.5vh;
                left: 78vh;
                font-size: 71px;
            }
            #show {
                position: absolute;
                top: 37.5vh;
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
                if($result = mysqli_query($mysqli, $sql)){
                    if(mysqli_num_rows($result) > 0){
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
                            echo "<tr id = '$hash' onclick = 'view_paper(this.id)' style = 'cursor: pointer; font-weight: bold;'>";
                                echo "<td>" . $row['sno'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                $date = explode('-',$row['Edate']);
                                echo "<td>" . $date[2].'/'.$date[1].'/'.$date[0] . "</td>";
                                echo "<td>" . $row['stime'] . "</td>";
                                echo "<td>" . $row['etime'] . "</td>";
                                echo "<td>" . $row['Tmarks'] . "</td>";
                                if ($row['eval'] == 'Done') {
                                    echo "<td><i style = 'color: green;' class = 'material-icons'>done</i></td>";
                                }
                                else {
                                    echo "<td><i style = 'color: red;' class = 'material-icons'>clear</i></td>";
                                }
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