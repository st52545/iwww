<div class="accinfo">
    <?php
    include_once './data/functions.php';
    if (!isset($_SESSION["id"])) {
        header("Refresh:0; url=./index.php");
    }

    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, username, email, datumRegistrace FROM uzivatele where id = " . $_SESSION["id"];
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $username = $row["username"];
    $email = $row["email"];
    $date = $row["datumRegistrace"];


    $booksBorrowed = getAmountBorrows($_SESSION["id"]);
    echo '<p>Logged in as: ' . $username . '</p>';
    echo '<p>Email: ' . $email . '</p>';
    echo '<p>Date registered: ' . $date . '</p>';
    echo '<p>Total amount of books borrowed: ' . $booksBorrowed . '</p>';
    ?>
</div>


<?php
    $sql2 = "SELECT * FROM pujcky WHERE uzivatel_id=". $_SESSION["id"] ." AND vraceno=0 ORDER BY datumVraceni ASC;";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        echo "<h2 class='noprint'>Currently borrowed books</h2>";
        echo "<table class='noprint'><tr><th>Name of the book</th><th>Author</th><th>Date of borrow</th><th>Return date</th><th>Extend return date</th></tr>";
        while ($row2 = $result2->fetch_assoc()) {
            $idbook = $row2["kniha_id"];
            $dateborrow = $row2["datumVypujceni"];
            $datereturn = $row2["datumVraceni"];
            $extended = $row2["prodlouzeno"];


            $sql3 = "SELECT knihy.id, autori.jmeno as autorJmeno, autori.prijmeni as autorPrijmeni, nazev as knihaNazev FROM knihy join autori on knihy.autor_id = autori.id WHERE knihy.id = ". $idbook;
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();
            $authorname = $row3["autorJmeno"];
            $authorsurname = $row3["autorPrijmeni"];
            $bookname = $row3["knihaNazev"];


            echo "<tr><td>".$bookname."</td><td>".$authorname." ".$authorsurname."</td><td>".$dateborrow."</td><td>".$datereturn."</td>";

            $amount = getAmountReservations($idbook);
            if ($amount == 0 && $extended == 0) {
                ?>
                <td><form method="post" action="/pages/extendBorrow.php">
                <input type="hidden" value="<?=$idbook?>" name="bookid">
                <input type="submit" value="Extend"></form></td></tr>
                <?php

            } else if ($extended == 1) {
                echo '<td><button disabled>You can only extend once</button></td></tr>';
            } else {
                echo '<td><button disabled>Already reserved</button></td></tr>';
            }
        }
    }
    echo "</table>";

$sql4 = "SELECT * FROM rezervace WHERE uzivatel_id=". $_SESSION["id"] . " ORDER BY datumRezervace DESC";
$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    echo "<h2 class='noprint'>Reservations</h2>";
    echo "<table class='noprint'><tr><th>Name of the book</th><th>Date of reservation</th><th>Expected availability</th><th>Cancel reservation</th></tr>";
    while ($row4 = $result4->fetch_assoc()) {
        $idbook = $row4["kniha_id"];
        $datereserve = $row4["datumRezervace"];

        $sql5 = "SELECT knihy.id, nazev as knihaNazev FROM knihy WHERE knihy.id = ". $idbook;
        $result5 = $conn->query($sql5);
        $row5 = $result5->fetch_assoc();
        $bookname = $row5["knihaNazev"];
        $expavailability = getAvailability($idbook);


        echo "<tr><td>".$bookname."</td><td>".$datereserve."</td><td>".$expavailability."</td>";
            ?>
            <td><form method="post" action="/pages/cancelReservation.php">
                    <input type="hidden" value="<?=$idbook?>" name="bookid">
                    <input type="submit" value="Cancel"></form></td></tr>
            <?php

    }
    echo "</table>";
}


$sql6 = "SELECT * FROM recenze WHERE uzivatel_id=". $_SESSION["id"];
$result6 = $conn->query($sql6);
if ($result6->num_rows > 0) {
    echo "<h2 class='noprint'>My ratings</h2>";
    echo "<table class='noprint'><tr><th>Name of the book</th><th>Rating</th><th>Change rating</th></tr>";
    while ($row6 = $result6->fetch_assoc()) {
        $idbook = $row6["kniha_id"];
        $rating = $row6["hodnoceni"];
        $sql7 = "SELECT id, nazev as knihaNazev FROM knihy WHERE knihy.id = ". $idbook;
        $result7 = $conn->query($sql7);
        $row7 = $result7->fetch_assoc();
        $bookname = $row7["knihaNazev"];



        echo "<tr><td>".$bookname."</td><td>".$rating. " ★</td>";

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
                <input type="hidden" value="<?=$row7["id"]?>" name="bookid">
                <input type="submit" value="Rate"></form></td></tr>
        <?php
    }
}
echo "</table>";




$sql7 = "SELECT * FROM pujcky WHERE uzivatel_id=". $_SESSION["id"] . " ORDER BY vraceno ASC, datumVypujceni DESC";
$result7 = $conn->query($sql7);
if ($result7->num_rows > 0) {
    echo "<h2>History of all borrowed books</h2>";
    echo "<table><tr><th>Name of the book</th><th>Author</th><th>Borrow date</th><th>Date of return</th><th>Sanction</th></tr>";
    while ($row7 = $result7->fetch_assoc()) {
        $idbook = $row7["kniha_id"];
        $dateborrow = $row7["datumVypujceni"];
        $datereturn = $row7["datumVraceni"];
        $returned = $row7["vraceno"];
        $sanction = $row7["sankce"];

            $sql8 = "SELECT knihy.id, autori.jmeno as autorJmeno, autori.prijmeni as autorPrijmeni, nazev as knihaNazev FROM knihy join autori on knihy.autor_id = autori.id WHERE knihy.id = " . $idbook;
            $result8 = $conn->query($sql8);
            $row8 = $result8->fetch_assoc();
            $authorname = $row8["autorJmeno"];
            $authorsurname = $row8["autorPrijmeni"];
            $bookname = $row8["knihaNazev"];
            if ($returned == 1) {
                $returnvalue = 'Returned';
            } else {
                $returnvalue = $datereturn;
            }

            echo "<tr><td>" . $bookname . "</td><td>" . $authorname . " " . $authorsurname . "</td><td>" . $dateborrow . "</td><td>" . $returnvalue . "</td><td>" . $sanction . ",-</td></tr>";
        }
    }
echo "</table>";

if (getAmountBorrows($_SESSION["id"]) != 0) {
    ?>
            <a class="noprint" href="?page=my_account&export=<?= $_SESSION["id"] ?>#download">Export history of borrowed books</a>
    <?php
    if(isset($_GET["export"])) {
        $userName = getUsername($_SESSION["id"]);
        $userid = $_SESSION["id"];
        $x=new XMLWriter();
        $x->openUri('borrowshistory.xml');
        $x->startDocument('1.0','UTF-8');
        $x->startElement('borrows');
        $x->writeAttribute('username',$userName);

        $sql9 = "SELECT * FROM pujcky WHERE uzivatel_id=".$userid;
        $result9 = $conn->query($sql9);
        while ($row9 = $result9->fetch_assoc()) {
            $idborrow = $row9["id"];
            $x->startElement('borrowid');
            $x->writeAttribute('id',$idborrow);
            $idbook = $row9["kniha_id"];
            $dateborrow = $row9["datumVypujceni"];
            $datereturn = $row9["datumVraceni"];
            $returned = $row9["vraceno"];
            $sanction = $row9["sankce"];
            $sql10 = "SELECT autori.jmeno as autorJmeno, autori.prijmeni as autorPrijmeni, nazev as knihaNazev FROM knihy join autori on knihy.autor_id = autori.id WHERE knihy.id = " . $idbook;
            $result10 = $conn->query($sql10);
            while ($row10 = $result10->fetch_assoc()) {
                $authorname = $row10["autorJmeno"];
                $authorsurname = $row10["autorPrijmeni"];
                $bookname = $row10["knihaNazev"];

                $x->startElement('name');
                $x->text($bookname);
                $x->endElement();

                $x->startElement('author');
                $x->text($authorname . ' ' . $authorsurname);
                $x->endElement();

                $x->startElement('borrowdate');
                $x->text($dateborrow);
                $x->endElement();

                $x->startElement('returndate');
                $x->text($datereturn);
                $x->endElement();

                $x->startElement('returned');
                if ($returned == 1) {
                    $x->text('Returned');
                    $x->endElement();
                } else {
                    $x->text('Not returned');
                    $x->endElement();

                    $x->startElement('sanction');
                    $x->text($sanction);
                    $x->endElement();
                }
                $x->endElement();
            }
        }
        $x->endElement();
        $x->endDocument();

        $x->flush();



        ?>
        <br><a id="download" href="borrowshistory.xml" download>Download</a>
        <?php
        if (isset($_GET["dl"])) {
            header("Refresh:0; url=../my_account.php");
        }


    }
}

?>










