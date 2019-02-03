<?php
session_start();

if (isset($_POST["bookid"])) {
    reserveBook($_POST["bookid"]);
    echo '<script language="javascript">';
    echo 'alert("Book successfully reserved.")';
    echo '</script>';
}
header("Refresh:0; url=../index.php?page=books");


function reserveBook($idbook) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $iduser = $_SESSION["id"];


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO rezervace(id, uzivatel_id, kniha_id, datumRezervace) VALUES (NULL, $iduser, $idbook, NOW())";
    $conn->query($sql);
}

?>

