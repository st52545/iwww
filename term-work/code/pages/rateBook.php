<?php
session_start();
$update = false;

if (isset($_POST["bookid"]) && isset($_POST["rating"])) {
    $update = rateBook($_POST["bookid"], $_POST["rating"]);
    echo '<script language="javascript">';
    echo 'alert("Book successfully rated. To change the rating, go to Your Account.")';
    echo '</script>';
}
if ($update) {
    header("Refresh:0; url=../index.php?page=my_account");
} else {
    header("Refresh:0; url=../index.php?page=books");
}



function rateBook($idbook, $rating) {

    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $iduser = $_SESSION["id"];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT COUNT(*) AS pocet FROM recenze where kniha_id=".$idbook." and uzivatel_id=".$iduser;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $pocet = $row["pocet"];


    if ($pocet > 0) {
        $sql2 = "UPDATE recenze SET hodnoceni =" . $rating . " WHERE uzivatel_id=".$iduser." AND kniha_id=".$idbook;
        $conn->query($sql2);
        $update = true;
    }
    else {
        $sql3 = "INSERT INTO recenze(id, hodnoceni, uzivatel_id, kniha_id) VALUES (NULL, $rating, $iduser, $idbook)";
        $conn->query($sql3);
        $update = false;
    }



return $update;

}
?>


