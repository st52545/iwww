<?php
session_start();

if (isset($_POST["iduser"])) {

    if (deleteUser($_POST["iduser"]) == 0) {
        echo '<script language="javascript">';
        echo 'alert("User still has books borrowed.")';
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("User deleted.")';
        echo '</script>';
    }
}
header("Refresh:0; url=../index.php?page=manageusers");


function deleteUser($iduser) {

    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT COUNT(*) AS pocet FROM pujcky WHERE vraceno = 0 AND uzivatel_id = " . $iduser;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $amount = $row["pocet"];
    if ($amount != 0) {
        return 0;
    } else {
        $sql = "DELETE FROM uzivatele where id = " . $iduser;
        $conn->query($sql);
        return 1;
    }
}

?>

