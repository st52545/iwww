<?php


function existUser($email, $userName) {
    $exist = FALSE;
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id FROM uzivatele where email = '" . $email . "' or username = '" . $userName . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exist = TRUE;
        }
    }
    return $exist;
}

function getQueuePosition($idbook) {
    $position = 1;
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM rezervace WHERE kniha_id=". $idbook . " ORDER BY datumRezervace DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["uzivatel_id"] == $_SESSION["id"]) {
                return $position;
            } else {
                $position += 1;
            }
        }
    }

    return -1;
}

function getAvailability($idbook) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $waittime =  getPositionQueue($idbook);
    $sql = "SELECT DATE_ADD(datumVraceni, INTERVAL " . $waittime . " MONTH) as datumVraceni FROM pujcky WHERE kniha_id=" . $idbook . " ORDER BY datumVraceni DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $date = $row["datumVraceni"];
    } else return -1;


    return $date;
}

function getPositionQueue($idbook) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $pozice = 0;

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM rezervace WHERE kniha_id=". $idbook;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pozice += 1;
            $iduser = $row["uzivatel_id"];
            if ($iduser == $_SESSION["id"]) {
                return $pozice;
            }
        }
    }
    return -1;
}

function getAmountReservations($idbook) {
    $amount = 0;
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT COUNT(*) as pocet FROM rezervace WHERE kniha_id=". $idbook;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $amount = $row["pocet"];

    return $amount;
}

function isAvailable($idbook) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT skladem FROM knihy where id = " . $idbook;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $copies = $row["skladem"];
        }
    }
    if ($copies > 0) {
        $available = true;
    }
    else {
        $available = false;
    }
    return $available;
}


function hasBorrowedReserved($idbook) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = 'st52545webzd2482';
    $iduser = $_SESSION["id"];
    $truefalse = false;

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT COUNT(*) AS pocet FROM pujcky where kniha_id = " . $idbook . " and uzivatel_id =" . $iduser . " and vraceno = 0";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc() ;
    $pocet = $row["pocet"];
    if ($pocet > 0) $truefalse = true;

    $sql = "SELECT COUNT(*) AS pocet FROM rezervace where kniha_id = " . $idbook . " and uzivatel_id =" . $iduser;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $pocet = $row["pocet"];
    if ($pocet > 0) $truefalse = true;

    return $truefalse;
}

function getRole($id) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = "st52545webzd2482";
    $role = null;


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT role FROM uzivatele where id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $role = $row["role"];
        }
    }
    return $role;
}

function getAmountBorrows($id) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = "st52545webzd2482";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT COUNT(*) as c FROM pujcky where uzivatel_id = " . $id;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $booksAmount = $row["c"];

    return $booksAmount;
}

function getBook($id) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = "st52545webzd2482";
    $book = "";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT nazev FROM knihy where id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $book = $row["nazev"];
        }
    }
    return $book;
}

function message($text) {
    $message = $text;
    echo "<script type='text/javascript'>alert('$message');</script>";
}


function getUsername($id) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = "st52545webzd2482";
    $user = null;


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT username FROM uzivatele where id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = $row["username"];
        }
    }
    return $user;
}

function getUserId($userName) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = "st52545webzd2482";


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id FROM uzivatele where username = '" . $userName ."';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row["id"];


    return $id;
}



function getEmail($id) {
    $servername = "sql2.webzdarma.cz";
    $username = "st52545webzd2482";
    $password = "Databaze1";
    $dbname = "st52545webzd2482";
    $user = null;


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT email FROM uzivatele where id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $email = $row["email"];
        }
    }
    return $email;
}
?>

