<?php
    require 'dbConnection.php';
    if (isset($_GET['name'])) {
        if ($_GET['name'] !== '') {
            $name = $_GET['name'];
            $query = "select username from empcreds where username ='".$name."'";
            $run_query = mysqli_query($dbConnection,$query);
            $result = mysqli_fetch_all($run_query,MYSQLI_ASSOC);
            //header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            exit(json_encode(''));
        }
    }
?>