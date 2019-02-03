<?php
include_once './data/functions.php';
if (getRole($_SESSION["id"]) == 'admin') {
    if (isset($_POST["register"])) {
        $passwd = md5($_POST["password"]);
        $passwd_check = md5($_POST["password_check"]);
        if ($passwd == $passwd_check) {
            $email = $_POST["email"];
            $username = $_POST["username"];
            if (!existUser($email, $username)) {
                $sql = "INSERT INTO uzivatele (id, username, password, email, datumRegistrace, role) VALUES (NULL, '" . $username . "', '" . $passwd . "', '" . $email . "', NOW(), '". $_POST["role"] ."')";
                $conn->query($sql);
                echo '<script language="javascript">';
                echo 'alert("New user registered.")';
                echo '</script>';
                header("Refresh:0; url=./index.php?page=manageusers");
            } else {
                echo 'E-Mail or username already exists';
            }
        } else {
            echo 'Passwords don´t match!';
        }
    }
}
?>


<div class="formm">
    <h2>Add user</h2>
    <form method="post">
        Role:<br>
        <input type="radio" name="role" value="admin"> Admin<br>
        <input type="radio" name="role" value="spravce"> Spravce<br>
        <input type="radio" name="role" value="zakaznik"> Zakaznik<br>
        E-Mail:<br>
        <input type="email" name="email" required><br>
        User name:<br>
        <input type="text" name="username" required><br>
        Password:<br>
        <input type="password" name="password" required><br>
        Password check:<br>
        <input type="password" name="password_check" required><br>
        <br>
        <input type="submit" name="register" value="Add user">
    </form>
</div>

<?php
$sql = "SELECT * FROM uzivatele ORDER BY username";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<h2>List of users</h2>";
    echo "<table><tr><th>Username</th><th>E-mail</th><th>Books borrowed</th><th>Date registered</th><th>Edit user</th><th>Remove user</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $iduser = $row["id"];
        $username = $row["username"];
        $email = $row["email"];
        $dateregister = $row["datumRegistrace"];
        $amountborrow = getAmountBorrows($row["id"]);


        echo "<tr><td>".$username."</td><td>".$email."</td><td>".$amountborrow."</td><td>".$dateregister."</td>";
        echo '<td><a class="link" href="?page=edituser&iduser='.$iduser.'">Edit</a></td>'; ?>

                <td><form action="/pages/deleteUser.php" method="post">
                        <input type="hidden" name="iduser" value="<?=$iduser?>">
                        <input type="submit" name="delete" value="Delete"></form></td></tr>
        <?php
    }
}
echo "</table>";
?>

