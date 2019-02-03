<?php
include_once './data/functions.php';

$sql = "SELECT * from pujcky ORDER BY datumVypujceni DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<h2>List of borrows</h2>";
    echo "<table><tr><th>ID</th><th>Book name</th><th>Username</th><th>Date of borrow</th><th>Date of return</th><th>Sanction</th><th>Extended</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $idborrow = $row["id"];
        $idbook = $row["kniha_id"];
        $iduser = $row["uzivatel_id"];
        $dateborrow = $row["datumVypujceni"];
        $datereturn = $row["datumVraceni"];
        $returned = $row["vraceno"];
        $sanction = $row["sankce"];

        if ($row["prodlouzeno"] == 1) {
            $extended = 'Already extended';
        } else $extended = 'Can extend';

        $sql2 = "SELECT username FROM uzivatele WHERE id=".$iduser;
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        $username = $row2["username"];

        $sql3 = "SELECT nazev FROM knihy WHERE id=".$idbook;
        $result3 = $conn->query($sql3);
        $row3 = $result3->fetch_assoc();
        $bookname = $row3["nazev"];


        echo "<tr><td>".$idborrow."</td><td>".$bookname."<td>".$username."</td><td>".$dateborrow."</td><td>".$datereturn."</td><td>".$sanction.",-</td><td>".$extended."</td>";
        if ($returned == 1) {
             echo '<td>Returned</td></tr>';
        } else {
            ?>
            <td><form action="/pages/returnBook.php" method="post">
                    <input type="hidden" name="idborrow" value="<?=$idborrow?>">
                    <input class="btn" type="submit" name="return" value="Return"></form></td></tr>
            <?php
        }

    }
}
echo "</table>";
?>







