<?php
session_start();
include './data/db.php';
include './data/auto_login.php';
include_once './data/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Library - Book reservation</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./styles/style.css">
        <link href='https://fonts.googleapis.com/css?family=Sarabun' rel='stylesheet'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="content">
            <header>
                <nav class="menu">

                    <a class="menuitem" id="menu_home" href="index.php">Home</a>
                    <a class="menuitem" id="menu_books" href="?page=books">Books</a>


                    <?php

                    if (isset($_SESSION["id"])) {
                        $prava = getRole($_SESSION["id"]);
                        echo '<a class="menuitem" id="menu_messages" href="?page=messages">Messages</a>';
                        if($prava == 'spravce' || $prava == 'admin') {

                            echo '<a class="menuitem" id="menu_managebooks" href="?page=managebooks">Manage books</a>';
                            echo '<a class="menuitem" id="menu_manageborr" href="?page=manageborrows">Manage borrows</a>';

                        }
                        if($prava == 'admin') {
                            echo '<a class="menuitem" id="menu_manageusers" href="?page=manageusers">Manage users</a>';
                        }
						echo '<a class="menuitem" id="menu_account" href="?page=my_account">Your account</a>';
                        echo '<a class="menuitem" id="menu_logout" href="?page=logout">Logout</a>';

                    } else {
                        echo '<a class="menuitem" id="menu_login" href="?page=login">Login</a>';
                        echo '<a class="menuitem" id="menu_register" href="?page=register">Register</a>';
                    }
                    ?>
                </nav>
            </header>
            <div class = "main_content">

                <?php
                $page = "";
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                    if ($page == "logout") {
                        include './data/logout.php';
                        header("Refresh:0; url=./index.php");
                    }
                    switch ($page) {
                        case "details" : include './pages/details.php'; break;
                        case "editbook" : include './pages/editBook.php'; break;
                        case "edituser" : include './pages/editUser.php'; break;
                        case "reply" : include './pages/reply.php'; break;
                        case "editauthor" : include './pages/editAuthor.php'; break;
                        case "my_account" : include './pages/my_account.php'; break;
                        case "manageauthors" : include './pages/manageAuthors.php'; break;
                        case "manageusers" : include './pages/manageUsers.php'; break;
                        case "manageborrows" : include './pages/manageBorrows.php'; break;
                        case "managebooks" : include './pages/manageBooks.php'; break;
                        case "books" : include './pages/books.php'; break;
                        case "messages" : include './pages/messages.php'; break;
                        case "login" : include './pages/login.php'; break;
                        case "register" : include './pages/register.php'; break;
                    }
                } else {
                    ?>
                    <section class="content mainpage">
                        <h1>Welcome to the library</h1>
                        <p>Here you can borrow books from our library for free!</p>
                        <p>If you are new here, please register in order to be able to borrow books</p>
                    </section>

                    <?php
                }


                ?>

            </div>
        </div>        
    <footer>
        <p>This project was created as a university project for subject IWWW in 2019.</p>
        <p>Project was made by Jan Pařízek, student of Information Technologies in Univerzita Pardubice.</p>
        <a href="#menu_home">Back to top</a>
    </footer>
    </body>
</html>