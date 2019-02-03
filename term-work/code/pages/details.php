<?php

if (isset($_GET["book"])) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $idbook = $_GET["book"];


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM knihy WHERE id=".$idbook;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $bookname = $row["nazev"];
    $genre = $row["zanr"];
    $year = $row["rokVydani"];
    $desc = $row["popis"];
    $idauthor = $row["autor_id"];

    $sql4 = "SELECT * FROM autori WHERE id=".$idauthor;
    $result4 = $conn->query($sql4);
    $row4 = $result4->fetch_assoc();
    $authorname = $row4["jmeno"];
    $authorsurname = $row4["prijmeni"];

    $sql2 = "SELECT ROUND(AVG(hodnoceni),1) as prumer FROM recenze WHERE kniha_id=".$idbook;
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $avgrating = $row2["prumer"] . ' ★';
    if ($avgrating == ' ★') {
        $avgrating = 'No ratings';
    }

    $sql3 = "SELECT COUNT(*) as pocet FROM pujcky WHERE kniha_id=".$idbook;
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_assoc();
    $amountborrow = $row3["pocet"];

}


?>

<div class="book">
    <h2><?=$bookname?> (<?=$authorname . ' ' . $authorsurname?>)</h2>
    <div id="details">
        <p>Year of release: <?=$year?></p>
        <h4>Description</h4>
        <p id="desc"><?=$desc?></p><br>
        <p>Average rating: <?=$avgrating?></p>
        <p>Borrowed: <?=$amountborrow?>x</p>
    </div>

    <a class="link" href="?page=books"><< Back to books</a>
</div>




