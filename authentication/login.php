<?php
    include_once '../db.php';
    session_start();

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            echo "success";
        } else {
            echo "Sai tên đăng nhập hoặc mật khẩu";
        }
    }
?>