<?php

if (isset($_GET["iduser"]) && getRole($_SESSION["id"]) == 'admin') {
    $iduser = $_GET["iduser"];
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM uzivatele WHERE id = " . $iduser;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $userName = $row["username"];
    $email = $row["email"];
    $role = $row["role"];

    if (isset($_POST["edit"])) {
        $userName = $_POST["userinput"];
        $email = $_POST["emailinput"];
        $role = $_POST["roleinput"];
        editUser($iduser, $userName, $email, $role);
        echo '<script language="javascript">';
        echo 'alert("User updated.")';
        echo '</script>';
        header("Refresh:0; url=../index.php?page=manageusers");
    }
}
else {
    header("Refresh:0; url=../index.php");
}



function editUser($iduser, $userName, $email, $role) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE uzivatele SET username='". $userName ."', email='".$email."', role='".$role."' where id = " . $iduser;
    $conn->query($sql);
}

?>
<div class="register_form">
<form method="post" action="">
    Username: <input name="userinput" type="text" value="<?php echo $userName;?>"><br>
    Email: <input name="emailinput" type="email" value="<?php echo $email;?>"><br>



    <select name="roleinput">
        <option <?php if ($role == "admin") echo 'selected';?> value="admin">Admin</option>
        <option <?php if ($role == "spravce") echo 'selected';?> value="spravce">Spravce</option>
        <option <?php if ($role == "zakaznik") echo 'selected';?> value="zakaznik">Zakaznik</option></select>
   </select>

    <input type="submit" value="Edit" name="edit">
</form>
</div>



