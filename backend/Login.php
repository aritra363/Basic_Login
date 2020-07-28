<?php
    session_start();
    if (isset($_GET['logout'])) {
        unset($_SESSION['username']);
        header("refresh:0;url=http://localhost/LoginSystem/index.html");
        die();
    }
    if (isset($_SESSION['username']) && !isset($_POST['switch'])) {
        echo "Welcome ".strtoupper($_SESSION['username'])."<br/>";
        echo "<a href='http://localhost/LoginSystem/index.html'>Click here to Redirect</a><br/>";
        echo "<a href='http://localhost/LoginSystem/backend/Login.php?logout=1'>Logout</a>";
        die();
    }
    // if (!isset($_SESSION['username']) && $_POST['switch'] != 0) {
    //     header("refresh:0;url=http://localhost/LoginSystem/index.html");
    //     die();
    // }
    require 'dbConnection.php';
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    if (trim($uname) === "" || trim($pass)=== "") {
        echo "username or password cannot be empty<br/>Redirecting in 2 seconds";
        header("refresh:2;url=http://localhost/LoginSystem/index.html");
    } else {
        if ($_POST['switch'] == 1) {
            #Login
            if (isset($_SESSION['username']) && $_SESSION['username'] === $uname) {
                echo "Welcome ".strtoupper($_SESSION['username'])."<br/>";
                echo "<a href='http://localhost/LoginSystem/index.html'>Click here to Redirect</a><br/>";
                echo "<a href='http://localhost/LoginSystem/backend/Login.php?logout=1'>Logout</a>";
                die();
            } else {
                $check_uname_exists = "select password from empcreds where username='".$uname."'";
                $check = mysqli_query($dbConnection,$check_uname_exists);
                if (mysqli_num_rows($check)) {
                    $unhash_password = password_verify($pass,mysqli_fetch_assoc($check)['password']);
                    if ($unhash_password) {
                        $_SESSION['username'] = $uname;
                        echo $_SESSION['username'];
                        echo "Login Succesfull<br/>Welcome $uname";
                        echo "<a href='http://localhost/LoginSystem/index.html'>Click here to Redirect</a><br/>";
                        echo "<a href='http://localhost/LoginSystem/backend/Login.php?logout=1'>Logout</a>";
                    } else {
                        echo "Username or Password Invalid<br/>Redirecting in 2 seconds";
                        header("refresh:2;url=http://localhost/LoginSystem/index.html");
                    }
                } else {
                    echo "Username or Password Invalid<br/>Redirecting in 2 seconds";
                    header("refresh:2;url=http://localhost/LoginSystem/index.html");
                }
            }
        } else {
            #register
            $hash_password = password_hash($pass,PASSWORD_DEFAULT);
            $check_uname = "select * from empcreds where username='".$uname."'";
            $check = mysqli_query($dbConnection,$check_uname);
           if (mysqli_num_rows($check)) {
               echo "Username ".$uname." already exists,Please try anything else!";
               echo "Redirecting in 2 seconds";
               header("refresh:2;url=http://localhost/LoginSystem/index.html");
           } else {
               $insert_data = "insert into empcreds (username,password) values ('".$uname."','".$hash_password."')";
               $run_query = mysqli_query($dbConnection,$insert_data);
               if ($run_query) {
                    echo "User registered Successfully<br/>Redirecting in 2 seconds";
                    header("refresh:2;url=http://localhost/LoginSystem/index.html");

                } else {
                    echo "Some thing went wrong!<br/>".mysqli_error($dbConnection);
                    echo "<a href='http://localhost/LoginSystem/index.html'>Click here to Redirect</a>";
                }
           }
        }
    }
?>