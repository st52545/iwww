<?php

if (isset($_GET["idbook"]) && getRole($_SESSION["id"]) != 'zakaznik') {
    $idbook = $_GET["idbook"];
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT  k.nazev, k.popis, k.rokVydani, k.zanr, k.pocetKs, k.skladem, a.id, a.jmeno, a.prijmeni FROM knihy k JOIN autori a ON k.autor_id=a.id WHERE k.id = " . $idbook;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $authorid = $row["id"];
    $bookname = $row["nazev"];
    $authorname = $row["jmeno"];
    $authorsurname = $row["prijmeni"];
    $desc = $row["popis"];
    $genre = $row["zanr"];
    $year = $row["rokVydani"];
    $amount = $row["pocetKs"];
    $instock = $row["skladem"];

    if (isset($_POST["edit"])) {
        $authorid = $_POST["authorform"];
        $bookname = $_POST["bookform"];
        $genre = $_POST["genreform"];
        $year = $_POST["yearform"];
        $amount = $_POST["stockform"];
        $i = 0;
        if ($amount > 0) {
            while(getIdNextUser($idbook) > 0 && $i != $amount) {
                $userid = getIdNextUser($idbook);
                $sql4 = "INSERT INTO pujcky(id, datumVypujceni, datumVraceni, vraceno, prodlouzeno, kniha_id, uzivatel_id) VALUES (NULL, NOW(), DATE_ADD(NOW(), INTERVAL 34 DAY), 0, 0, $idbook, $userid) ";
                $conn->query($sql4);
                $sql5 = "DELETE FROM rezervace where uzivatel_id=".$userid." and kniha_id=".$idbook;
                $conn->query($sql5);
                $sql6 = "INSERT INTO `zpravy`(`id`, `zprava`, `datum`, `precteno`, `odesilatel_id`, `adresat_id`) VALUES (NULL, 'Vámi rezervovaná kniha ".getBook($idbook)." vám byla propůjčena ',NOW(),0,1,".$userid.")";
                $conn->query($sql6);
                $sql6 = "UPDATE knihy set skladem = skladem - 1 where id=".$idbook;
                $conn->query($sql6);
                $i += 1;
            }
        }
        editBook($idbook, $authorid, $bookname, $genre, $year, $amount);
        echo '<script language="javascript">';
        echo 'alert("Book updated.")';
        echo '</script>';
        header("Refresh:0; url=../index.php?page=managebooks");
    }
}
else {
    header("Refresh:0; url=../index.php");
}



function editBook($idbook, $idauthor, $bookname, $genre, $year, $desc, $amount) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE knihy SET nazev='". $bookname ."', zanr='".$genre."', rokVydani='".$year."', popis = '".$desc."', pocetKs = pocetKs +'".$amount."', skladem = skladem +'".$amount."', autor_id=".$idauthor." where id = " . $idbook;
    $conn->query($sql);
}

?>
<div class="register_form">
<form method="post" action="">
    Book name:<br> <input name="bookform" type="text" value="<?php echo $bookname;?>"><br>
    Author:<br> <select name="authorform">
        <?php
        $sql3 = "SELECT id, jmeno, prijmeni, id FROM autori ORDER BY prijmeni";
        $result3 = $conn->query($sql3);
        if ($result3->num_rows > 0) {
            while ($row3 = $result3->fetch_assoc()) {
                $aid = $row3["id"];
                $aname = $row3["jmeno"];
                $asurname = $row3["prijmeni"];
                $afullname = $aname .' '. $asurname;
                echo '<option value="'.$aid.'">'.$afullname.'</option>';
            }
        }
        ?>
    </select><br>
    Genre:<br> <input  name="genreform" type="text" value="<?php echo $genre ;?>"><br>
    Year of release:<br> <input  name="yearform" type="number" value="<?php echo $year ;?>"><br>
    Description:<br> <textarea  name="descform" type="text"><?php echo $desc ;?></textarea><br>
    Add to stock:<br> <input  name="stockform" type="number" value="0"><br>




    <input type="submit" value="Edit" name="edit">
</form>
</div>


<?php
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
?>


