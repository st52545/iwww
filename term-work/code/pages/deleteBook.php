<?php
session_start();

if (isset($_POST["idbook"])) {

    if (deleteBook($_POST["idbook"]) == 0) {
        echo '<script language="javascript">';
        echo 'alert("Book is still borrowed.")';
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Book deleted.")';
        echo '</script>';
    }
}
header("Refresh:0; url=../index.php?page=managebooks");


function deleteBook($idbook) {

    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT COUNT(*) AS pocet FROM pujcky where kniha_id = " . $idbook;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $amount = $row["pocet"];
    if ($amount > 0) {
        return 0;
    } else {
        $sql = "DELETE FROM knihy where id = " . $idbook;
        $conn->query($sql);
        return 1;
    }
}

?>

