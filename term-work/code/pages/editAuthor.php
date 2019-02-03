<?php

if (isset($_GET["idauthor"]) && getRole($_SESSION["id"]) == 'admin') {
    $idauthor = $_GET["idauthor"];
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM autori WHERE id = " . $idauthor;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $name = $row["jmeno"];
    $surname = $row["prijmeni"];

    if (isset($_POST["edit"])) {
        $name = $_POST["nameform"];
        $surname = $_POST["surnameform"];
        editAuthor($idauthor, $name, $surname);
        echo '<script language="javascript">';
        echo 'alert("Author updated.")';
        echo '</script>';
        header("Refresh:0; url=../index.php?page=manageauthors");
    }
}
else {
    header("Refresh:0; url=../index.php");
}



function editAuthor($idauthor, $name, $surname) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE autori SET jmeno='". $name ."', prijmeni='".$surname."' where id = " . $idauthor;
    $conn->query($sql);
}

?>
<div class="register_form">
<form method="post">
    Name: <input name="nameform" type="text" value="<?php echo $name;?>"><br>
    Surname: <input name="surnameform" type="text" value="<?php echo $surname;?>"><br>


    <input type="submit" value="Edit" name="edit">
</form>
</div>



