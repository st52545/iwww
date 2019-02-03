<?php
include_once './data/functions.php';
$servername = "sql2.webzdarma.cz";
$username = "st52545webzd2482";
$password = "Databaze1";
$dbname = 'st52545webzd2482';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role = getRole($_SESSION["id"]);
if ($role == 'spravce' || $role == 'admin') {
    ?>
    <div class="formm">
        <h2>New message</h2>
        <form action="" method="post">
            Send to:<br>
            <select name="username">
            <?php
            if (isset($_GET["reply"])) {
                $username = $_GET["reply"];
                ?> <option value="<?=getUserId($username)?>"><?php echo $username?></option> <?php
                $sql4 = "SELECT id, username FROM uzivatele WHERE username != '".$username."'";
                $result4 = $conn->query($sql4);
                while ($row4 = $result4->fetch_assoc()) {
                    ?>
                    <option value="<?=$row4["id"]?>"><?php echo $row4["username"]?></option>
                    <?php
            }

            } else {
                $sql4 = "SELECT id, username FROM uzivatele";
                $result4 = $conn->query($sql4);
                while ($row4 = $result4->fetch_assoc()) {
                    ?>
                    <option value="<?=$row4["id"]?>"><?php echo $row4["username"]?></option>
                    <?php
                }
            }
            ?>
            </select><br>



            Message:<br>
            <textarea name="textform"></textarea><br><br>
            <input type="hidden" name="userid" value="<?=$_SESSION["id"]?>">
            <input type="submit" name="send" value="Send message">
        </form>
    </div>
    <?php
} else {
    ?>
    <div class="register_form">
        <h2>Send us a message</h2>
        <form action="" method="post">
            Message:<br>
            <textarea  name="textform"></textarea><br><br>
            <input type="hidden" name="userid" value="<?=$_SESSION["id"]?>">
            <input type="submit" name="send" value="Send message">
        </form>
    </div>
    <?php
}

if (isset($_POST["send"])) {
    if ($role == 'spravce' || $role == 'admin') {
        $message = $_POST["textform"];
        $sendto = $_POST["username"];
        $sendid = getUserId($sendto);
        $sql3 = "INSERT INTO zpravy(zprava, datum, precteno, odesilatel_id, adresat_id) VALUES('".$message."', NOW(), 0, ".$_SESSION["id"].", ".$sendto.")";
        echo 'Message has been sent.';
        $conn->query($sql3);
    } else {
        $message = $_POST["textform"];
        echo 'Message has been sent to the staff.';
        $sql4 = "INSERT INTO zpravy(zprava, datum, precteno, odesilatel_id, adresat_id) 
                VALUES('".$message."', NOW(), 0, ".$_SESSION["id"].", 1), 
                      ('".$message."', NOW(), 0, ".$_SESSION["id"].", 2)";
        $conn->query($sql4);
    }
}


if (isset($_GET["read"])) {
    $idmessage = $_GET["read"];
    $sql5 = "UPDATE zpravy SET precteno=1 WHERE id=".$idmessage;
    $conn->query($sql5);
}

$sql = "SELECT * FROM zpravy where adresat_id = ". $_SESSION["id"] . " and precteno = 0 order by datum desc;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>New messages</h2>";

    while ($row = $result->fetch_assoc()) {
        $idmessage = $row["id"];
        $sentfrom = getUsername($row["odesilatel_id"]);
        $sentto = getUsername($_SESSION["id"]);
        $message = $row["zprava"];
        $date = $row["datum"];
?>
        <div class="messages">
            <p><b>From: <?=$sentfrom?></b> [<?=$date?>]</p>
            <p id="message"><?=$message?></p>
            <a href="?page=messages&read=<?=$idmessage?>">Mark as read</a> <a href="?page=messages&reply=<?=$sentfrom?>">Reply</a>
        </div>
<?php
    }
}
$sql2 = "SELECT * FROM zpravy where adresat_id = ". $_SESSION["id"] . " and precteno = 1 order by datum desc;";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    echo "<h2>Old messages</h2>";
    while ($row2 = $result2->fetch_assoc()) {
        $sentfrom = getUsername($row2["odesilatel_id"]);
        $sentto = getUsername($_SESSION["id"]);
        $message = $row2["zprava"];
        $date = $row2["datum"];
        ?>
        <div class="messages">
            <p><b>From: <?=$sentfrom?></b> [<?=$date?>]</p>
            <p id="message"><?=$message?></p>
            <a href="?page=messages&reply=<?=$sentfrom?>">Reply</a>
        </div>
        <?php
    }
}

?>






