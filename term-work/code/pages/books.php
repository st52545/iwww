<?php

$servername = "sql2.webzdarma.cz";
$username = "st52545webzd2482";
$password = "Databaze1";
$dbname = 'st52545webzd2482';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT disabled, knihy.id, nazev, jmeno, prijmeni, zanr, popis, skladem FROM knihy JOIN autori ON knihy.autor_id=autori.id ORDER BY nazev ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>List of our books</h2>";
    echo "<table><tr class='header'><th>Name of the book</th><th>Author</th><th>Copies available</th><th>Borrow or reserve</th><th>Rate</th></tr>";

    while($row = $result->fetch_assoc()) {
        if ($row["disabled"] == 1) {
            continue;
        }
        $bookname = $row["nazev"];
        $bookid = $row["id"];

        echo '<tr><td><a class="link" href="?page=details&book='.$bookid.'">'.$bookname.'</a></td>';
        if (!isAvailable($row["id"]) && isset($_SESSION["id"])) {
            echo "<td class='notavailable'>".$row["jmeno"]." ".$row["prijmeni"]."</td><td class=\"center\">".$row["skladem"]."</td>";
        } else {
            echo "<td>".$row["jmeno"]." ".$row["prijmeni"]."</td><td class=\"center\">".$row["skladem"]."</td>";
        }

        if (!isset($_SESSION["id"])) {
            echo '<td><button disabled>Log in to borrow</button></td>';
        }
        else if (hasBorrowedReserved($row["id"])) {
            ?>
            <td><input disabled type="button" value="Already borrowed or reserved" class="button" id="btnOwned"></td>
            <?php
        }
        else if (isAvailable($row["id"]) && isset($_SESSION["id"])) {
            ?>
            <td><form method="post" action="/pages/borrowBook.php">
                <input type="hidden" value="<?=$row["id"]?>" name="bookid">
                <input class="btn" class="btn" type="submit" value="Borrow"></form></td>
            <?php
        }

        else {
            ?>
             <td><form method="post" action="/pages/reserveBook.php">
                <input type="hidden" value="<?=$row["id"]?>" name="bookid">
                <input class="btn" type="submit" value="Reserve"></form></td>
            <?php
        }

        if (isset($_SESSION["id"])) {
            $sql2 = "SELECT COUNT(*) as pocet FROM recenze WHERE uzivatel_id = ". $_SESSION["id"] ." AND kniha_id=". $row["id"];
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc() ;
            $pocet = $row2["pocet"];

            if ($pocet > 0) {
                echo '<td><p>Already rated</p></td></tr>';
            } else {
                ?>
                <td>
                    <form method="post" action="/pages/rateBook.php">
                        <select name="rating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <input type="hidden" value="<?=$row["id"]?>" name="bookid">
                        <input class="btn" type="submit" value="Rate"></form></td></tr>
                <?php
            }
        } else {
            echo '<td><p>Login to rate</p></td></tr>';
        }

    }
    echo "</table>";
} else {
    echo "0 results";
}



?>







