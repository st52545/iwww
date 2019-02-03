<?php
session_start();

if (isset($_POST["bookid"])) {
    extendBorrow($_POST["bookid"]);
    echo '<script language="javascript">';
    echo 'alert("Borrow time extended by a month.")';
    echo '</script>';
}
header("Refresh:0; url=../index.php?page=my_account");


function extendBorrow($idbook) {

    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $iduser = $_SESSION["id"];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE pujcky SET datumVraceni = DATE_ADD(datumVraceni, INTERVAL 1 MONTH), prodlouzeno=1 where kniha_id = " . $idbook ." and uzivatel_id=". $iduser;
    $conn->query($sql);
}

?>

