<?php
include_once './data/functions.php';
if (isset($_POST["register"])) {
    $passwd = md5($_POST["password"]);
    $passwd_check = md5($_POST["password_check"]);
    if ($passwd == $passwd_check) {
        $email = $_POST["email"];
        $username = $_POST["username"];
        if (!existUser($email, $username)) {           
            $sql = "INSERT INTO uzivatele (id, username, password, email, datumRegistrace, role) VALUES (NULL, '" . $username . "', '" . $passwd . "', '" . $email . "', NOW(), 'zakaznik')";
            $conn->query($sql);
            echo '<script language="javascript">';
            echo 'alert("Successfully registered, you can now log in!")';
            echo '</script>';
            header("Refresh:0; url=./index.php?page=login");
        } else {
            echo 'E-Mail or username already exists';
        }
    } else {
        echo 'Passwords don´t match!';
    }
}
?>

<div class="formm">
    <form action="" method="post">
        E-Mail:<br>
        <input type="email" name="email" required><br>
        User name:<br>
        <input type="text" name="username" required><br>
        Password:<br>
        <input type="password" name="password" required><br>
        Password check:<br>
        <input type="password" name="password_check" required><br><br>
        <input type="submit" name="register" value="Register">
    </form>
</div>