<?php
session_start();

if (isset($_POST["bookid"])) {
    borrowBook($_POST["bookid"]);
    echo '<script language="javascript">';
    echo 'alert("Book successfully borrowed.")';
    echo '</script>';
}
header("Refresh:0; url=../index.php?page=books");


function borrowBook($idbook) {

    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $iduser = $_SESSION["id"];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE knihy SET skladem = skladem - 1 where id = " . $idbook;
    $conn->query($sql);


    $sql2 = "INSERT INTO pujcky(id, datumVypujceni, datumVraceni, vraceno, prodlouzeno, kniha_id, uzivatel_id) VALUES (NULL, NOW(), DATE_ADD(NOW(), INTERVAL 34 DAY), 0, 0, $idbook, $iduser)";
    $conn->query($sql2);


}

?>

