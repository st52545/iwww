<div class="formm">
    <h2>Add author</h2>
    <form method="post">
        Name:<br>
        <input type="text" name="nameform" required><br>
        Surname:<br>
        <input type="text" name="surnameform" required><br><br>
        <input type="submit" name="add" value="Add author">
    </form>
</div>

<?php
include_once './data/functions.php';

if (isset($_POST["add"])) {
    $authorname = $_POST["nameform"];
    $authorsurname = $_POST["surnameform"];
    $sql4 = "INSERT INTO autori(id, jmeno, prijmeni) VALUES (NULL, '".$authorname."', '".$authorsurname."')";
    $conn->query($sql4);
    echo '<script language="javascript">';
    echo 'alert("Author added.")';
    echo '</script>';
    header("Refresh:0; url=../index.php?page=manageauthors");
}

$sql = "SELECT * from autori ORDER BY prijmeni";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<h2>List of authors</h2>";
    echo "<table><tr><th>ID</th><th>Name</th><th>Books in library</th><th>Edit</th><th>Delete</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $idauthor = $row["id"];
        $authorname = $row["jmeno"];
        $authorsurname = $row["prijmeni"];

        $sql2 = "SELECT COUNT(*) AS pocet FROM knihy WHERE autor_id=".$idauthor;
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        $booksamount = $row2["pocet"];





        echo "<tr><td>".$idauthor."</td><td>".$authorsurname." ".$authorname." </td><td>".$booksamount."</td>";
        echo '<td><a class="link" href="?page=editauthor&idauthor='.$idauthor.'">Edit</a></td>'; ?>

        <td><form action="/pages/deleteAuthor.php" method="post">
            <input type="hidden" name="idauthor" value="<?=$idauthor?>">
            <input type="submit" name="delete" value="Delete"></form></td></tr>
    <?php
    }
}
echo "</table>";
?>







