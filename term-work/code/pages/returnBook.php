<?php
session_start();


if (isset($_POST["idborrow"])) {
        $sanction = returnBook($_POST["idborrow"]);
        if ($sanction > 0) {
            echo '<script language="javascript">';
            echo 'alert("Book returned. User returned late and pays a sanction.")';
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Book returned. Returned in time.")';
            echo '</script>';
        }

}
header("Refresh:0; url=../index.php?page=manageborrows");


function returnBook($idborrow) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "UPDATE pujcky SET vraceno=1 where id = " . $idborrow;
    $conn->query($sql);
    $sql2 = "SELECT kniha_id, datumVraceni, DATEDIFF(NOW(), datumVraceni) as rozdil FROM pujcky where id = " . $idborrow;
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $diff = $row2["rozdil"] * 15;
    $bookid = $row2["kniha_id"];
    if ($diff > 0) {
        $sql3 = "UPDATE pujcky SET sankce = ".$diff." where id = " . $idborrow;
        $conn->query($sql3);
    } else {
        $sql3 = "UPDATE pujcky SET sankce = 0 FROM pujcky where id = " . $idborrow;
        $conn->query($sql3);
    }

    if(getIdNextUser($bookid) > 0) {
        $userid = getIdNextUser($bookid);
        $sql4 = "INSERT INTO pujcky(id, datumVypujceni, datumVraceni, vraceno, prodlouzeno, kniha_id, uzivatel_id) VALUES (NULL, NOW(), DATE_ADD(NOW(), INTERVAL 34 DAY), 0, 0, $bookid, $userid) ";
        $conn->query($sql4);
        $sql5 = "DELETE FROM rezervace where uzivatel_id=".$userid." and kniha_id=".$bookid;
        $conn->query($sql5);
        $sql6 = "INSERT INTO `zpravy`(`id`, `zprava`, `datum`, `precteno`, `odesilatel_id`, `adresat_id`) VALUES (NULL, 'Vámi rezervovaná kniha ".getBook($bookid)." vám byla propůjčena ',NOW(),0,1,".$userid.")";
        $conn->query($sql6);
    } else {
        $sql4 = "UPDATE knihy SET skladem = skladem+1 where id=" . $bookid;
        $conn->query($sql4);
    }
    return $diff;
}

function getIdNextUser($idbook) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT uzivatel_id FROM rezervace where kniha_id = " . $idbook . " ORDER BY datumRezervace";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userid = $row["uzivatel_id"];
    } else {
        $userid = -1;
    }

    return $userid;
    }

function getBook($id) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = "st52545webzd2482";
    $book = "";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT nazev FROM knihy where id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $book = $row["nazev"];
        }
    }
    return $book;
}



?>

