<?php
if (isset($_POST["login"])) {
    $name = $_POST["username"];
    $passwd = md5($_POST["password"]);
    $sql = "SELECT id, username FROM uzivatele where username = '" . $name . "' and password = '" . $passwd . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            if (isset($_POST["autologin"])) {
                setcookie("id", $_SESSION["id"], time() + (86400 * 7), "/");
            }
            header("Refresh:0; url=./index.php?page=my_account");
        }
    } else {
        echo "Wrong username or password";
    }
}
?>

<div class="login_form">
    <form method="post">
        Username:<br> <input type="text" name="username" required><br>
        Password:<br> <input type="password" name="password" required><br>
        <input type="checkbox" name="autologin" value="1"> Stay logged in<br><br>
        <input type="submit" name="login" value="LogIn">
    </form>
</div>