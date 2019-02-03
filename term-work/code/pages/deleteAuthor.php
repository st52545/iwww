<?php
session_start();


if (isset($_POST["idauthor"])) {
        if (deleteAuthor($_POST["idauthor"]) == 1) {
            echo '<script language="javascript">';
            echo 'alert("Author and his books deleted.")';
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("There are still books borrowed from this author.")';
            echo '</script>';
        }

}
header("Refresh:0; url=../index.php?page=manageauthors  ");


function deleteAuthor($idauthor) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id FROM knihy WHERE autor_id=".$idauthor;
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $bookid = $row["id"];
        $sql2 = "SELECT kniha_id, vraceno FROM pujcky WHERE kniha_id=".$bookid;
        $result2 = $conn->query($sql2);
        while ($row2 = $result2->fetch_assoc()) {
            if ($row2["vraceno"] == 0) {
                return -1;
            }
        }
    }
    $sql3 = "DELETE FROM autori where id = " . $idauthor;
    $conn->query($sql3);
    return 1;
}

?>

