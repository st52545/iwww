<div class="formm">
    <h2>Add book</h2>
    <form id="addform" method="post" action="">
        Book name:<br> <input name="bookform" type="text"><br>
        Author:<br> <select name="authorform">
            <?php
            $sql3 = "SELECT id, jmeno, prijmeni, id FROM autori";
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
        </select><a class="link" href="../index.php?page=manageauthors">Manage authors</a><br>
        Genre:<br> <input  name="genreform" type="text"><br>
        Year of release:<br> <input  name="yearform" type="number"><br>
        Add to stock:<br> <input  name="stockform" type="number"><br>
        Description:<br><textarea name="descform"></textarea><br><br>
        <input type="submit" value="Add" name="add">
    </form>
</div>

<?php
include_once './data/functions.php';

if (isset($_POST["add"])) {
    $authorid = $_POST["authorform"];
    $bookname = $_POST["bookform"];
    $genre = $_POST["genreform"];
    $year = $_POST["yearform"];
    $amount = $_POST["stockform"];
    $desc = $_POST["descform"];
    $sql4 = "INSERT INTO knihy(id, nazev, zanr, rokVydani, pocetKs, skladem, autor_id, popis) VALUES (NULL, '".$bookname."', '".$genre."', ".$year.", ".$amount.", ".$amount.", ".$authorid.", '".$desc."')";
    $conn->query($sql4);
    echo '<script language="javascript">';
    echo 'alert("Book added.")';
    echo '</script>';
    header("Refresh:0; url=../index.php?page=managebooks");
}

$sql = "SELECT knihy.id, knihy.zanr as zanr, rokVydani as rok, pocetKs, skladem, autori.jmeno as autorJmeno, autori.prijmeni as autorPrijmeni, nazev as knihaNazev FROM knihy join autori on knihy.autor_id = autori.id ORDER BY knihaNazev";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<h2>List of books</h2>";
    echo "<table class='tablee'><tr><th>Name</th><th>Author</th><th>Genre</th><th>Year of release</th><th>Borrowed</th><th>Avg. rating</th><th>Available/Total</th><th>Edit</th><th>Delete</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $idbook = $row["id"];
        $authorname = $row["autorJmeno"];
        $authorsurname = $row["autorPrijmeni"];
        $bookname = $row["knihaNazev"];
        $bookgenre = $row["zanr"];
        $bookyear = $row["rok"];
        $available = $row["skladem"];
        $totalstock = $row["pocetKs"];
        $avgrating = 'No ratings';

        $sql2 = "SELECT COUNT(*) AS pocet FROM pujcky WHERE kniha_id=".$idbook;
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        $timesborrowed = $row2["pocet"];

        $sql3 = "SELECT ROUND(AVG(hodnoceni), 1) AS prumer FROM recenze WHERE kniha_id=".$idbook;
        $result3 = $conn->query($sql3);
        $row3 = $result3->fetch_assoc();
        $avgrating = $row3["prumer"]  . ' ★';
        if ($avgrating == ' ★') {
            $avgrating = 'No ratings';
        }



        echo "<tr><td>".$bookname."</td><td>".$authorname." ".$authorsurname."</td><td>".$bookgenre."</td><td>".$bookyear."</td><td>".$timesborrowed."x</td><td>".$avgrating."</td><td>".$available. '/'.$totalstock."</td>";
        echo '<td><a class="link" href="?page=editbook&idbook='.$idbook.'">Edit</a></td>'; ?>

        <td><form action="/pages/deleteBook.php" method="post">
            <input type="hidden" name="idbook" value="<?=$idbook?>">
            <input type="submit" name="delete" value="Delete"></form></td></tr>
    <?php
    }
}
echo "</table>";
?>







