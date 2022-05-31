<!DOCTYPE html>
<html>
<head>
    <title>The Wall</title>
    <link rel="stylesheet" href="signUpStyling.css">
</head>
<br><br>
<div class="whiteBox">
<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "reviewpage");
if (isset($_POST['username'])) {

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $defaultProfilePic = "defaultProfilePicture.jpg";

    // verificam daca s-au completat formurile, cu un default value daca nu au fost completate.
    // posibil aici sa facem si o validare in care verificam daca putem folosii datele de la user.

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE userName = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // daca exista userName
    if ($result->num_rows > 0) {

        ?>
        <h1>Username taken! </h1>
        <h3>Please try again </h3>
        <?php

    } else {
        // daca nu exista => create

        $_SESSION["username"]=$_POST['username'];

        $createStmt = $mysqli->prepare("INSERT INTO users(lastName, firstName, userName, password, profilePicture) VALUES (?, ?, ?, ?, ?)");
        $createStmt->bind_param("sssss", $_POST['lastname'], $_POST['firstname'], $_POST['username'], $password, $defaultProfilePic);
        $createStmt->execute();
        $createStmt->close();

        $stmt = $mysqli->prepare("SELECT * FROM users WHERE userName = ?");
        $stmt->bind_param("s", $_POST['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result -> fetch_assoc()) {
            echo 'test';
            $_SESSION["username"] = $_POST['username'];
            $_SESSION["userID"] = $row['userID'];
            header("location:mainFeed.php");
        }
    }
}

?>

<h1>Another Critic-to-be breaks free from society and questions the Man</h1>
    <br>
<div class="form">
    <form method="post" action="signUp.php">
        <div>
            <label>
                Lastname:
                <input type="text" autocomplete="off" name="lastname" value="" class="lastnameInput" placeholder="Enter Last Name"/>
            </label>
        </div>
        <div>
            <label>
                Firstname:
                <input type="text" autocomplete="off" name="firstname" value="" class="firstnameInput" placeholder="Enter First Name"/>
            </label>
        </div>
        <div>
            <label>
                Username:
                <input type="text" autocomplete="off" name="username" value="" class="usernameInput" placeholder="Enter Username"/>
            </label>
        </div>
        <div>
            <label>
                Password:
                <input type="password" autocomplete="off" name="password" value="" class="passwordInput" placeholder="********"/>
            </label>
        </div>
        <br>
        <button type="submit"> Register! </button>
    </form>
</div>
<br>
</div>

</html>