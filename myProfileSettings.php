<!DOCTYPE html>
<html>
<head>
    <title>The Wall</title>
    <link rel="stylesheet" href="mainFeedStyling.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap Css -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

</head>
<br><br>
<div class="whiteBox">
    <?php
    session_start();
    $_SESSION['mysqli'] = $mysqli = new mysqli("localhost", "root", "", "reviewpage");
    ?>
    <div class="leftSide">
        <?php
        $stmt = $mysqli->prepare("SELECT profilePicture FROM users WHERE userName = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result -> fetch_assoc()) {
            ?>
            <img src="<?= $row['profilePicture'] ?>", width='100', height='100'>
            <?php
            echo $_SESSION['username'];

        }

        if (isset($_POST['newUsername'])){
            $stmt = $_SESSION['mysqli']->prepare("UPDATE users SET userName = ? WHERE userID = ?");
            $stmt->bind_param("si", $_POST['newUsername'], $_SESSION['userID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $_SESSION['username'] = $_POST['newUsername'];
            header("Refresh:1");
        }

        if (isset($_POST['imagePath'])){
            $stmt = $_SESSION['mysqli']->prepare("UPDATE users SET profilePicture = ? WHERE userID = ?");
            $stmt->bind_param("si", $_POST['imagePath'], $_SESSION['userID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            header("Refresh:1");
        }

        ?>


    </div>
    <div class="middle">
        <form method="post" action="">
            <input type="text" autocomplete="off" name="newUsername" placeholder="Enter new username">
            <input type="submit" placeholder="Change Username">
        </form>
        <form method="post" action="">
            <input type="file" name="imagePath">
            <input type="submit" placeholder="Change Username">
        </form>
    </div>
    <div class="rightSide">
        <a href="mainFeed.php">Back to main page</a>
    </div>
</div>