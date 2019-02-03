<?php
session_start();

if (isset($_POST["bookid"])) {
    cancelReservation($_POST["bookid"]);
    echo '<script language="javascript">';
    echo 'alert("Reservation canceled.")';
    echo '</script>';
}
header("Refresh:0; url=../index.php?page=my_account");


function cancelReservation($idbook) {

    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $iduser = $_SESSION["id"];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM rezervace where kniha_id = " . $idbook ." and uzivatel_id=". $iduser;
    $conn->query($sql);
}

?>

