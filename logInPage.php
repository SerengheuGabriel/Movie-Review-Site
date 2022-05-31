<!DOCTYPE html>
<html>
<head>
    <title>The Wall</title>
    <link rel="stylesheet" href="logInStyling.css">
</head>
<br><br>
<div class="whiteBox">
<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "reviewpage");
if (isset($_POST['username'])) {

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE userName = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while ($row = $result -> fetch_assoc()) {
        if (password_verify($_POST['password'], $row['password'])) {

            $_SESSION["username"] = $_POST['username'];
            $_SESSION["userID"] = $row['userID'];
            header("location:mainFeed.php");

        } else {
            ?>
            <h1>Parola Gresita! </h1>
            <h3>Incercati din nou </h3>
            <?php

        }
    }
}

?>

<h1>Welcome! Please insert username and password</h1>
<div class="form">
    <form method="post" action="logInPage.php">
        <div>
            <label>
                Username:
                <input type="text" name="username" value="" autocomplete="off"/>
            </label>
        </div>
        <div>
            <label>
                Password:
                <input type="password" name="password" value=""/>
            </label>
        </div>
        <button type="submit"> Log In </button>
    </form>
</div>
    <br>
<?php