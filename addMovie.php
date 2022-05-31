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
            <img src="<?= $row['profilePicture'] ?>", width='50%', max-height='30%'>
            <?php
            echo $_SESSION['username'];

        }

        ?>
        <div class="extras">
            <?php
            if ($_SESSION['username'] == "FreddiesPizza") {
                ?>
                <div class="addMovie">
                    <a href="addMovie.php">Add Movie</a>
                </div>
                <?php
            }
            ?>
            <div class="settings">
                <a href="myProfileSettings.php">Settings</a>
            </div>
            <div class="logOut">
                <a href="index.php">Log Out</a>
            </div>
        </div>
    </div>

    <div class="middle">
        <?php
        if (isset($_POST['movieTitle'])) {
            $stmt = $mysqli->prepare("SELECT * FROM movies WHERE movieTitle = ?");
            $stmt->bind_param("s", $_POST['movieTitle']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {

                ?>
                <h1>Movie already exists! </h1>
                <?php

            } else {
                // daca nu exista => create
                $releaseYear = intval($_POST['movieReleaseYear']);

                $createStmt = $mysqli->prepare("INSERT INTO movies(movieTitle, moviePic, movieReleaseYear) VALUES (?, ?, ?)");
                $createStmt->bind_param("ssi", $_POST['movieTitle'], $_POST['moviePic'], $releaseYear);
                $createStmt->execute();
                $createStmt->close();

            }
        }

        ?>

        <div class="addMovie">
            <form method="post" action="">
                <label class="order1">
                    Movie Title:
                    <input type="text" autocomplete="off" name="movieTitle" value="" placeholder="Enter Movie Title"/>
                </label>
                <label class="order2">
                    Movie Poster:
                    <input type="file" name="moviePic">
                </label>
                <label class="order3">
                    Movie Release Year:
                    <input type="text" autocomplete="off" name="movieReleaseYear" value="" placeholder="Enter Movie Release Year"/>
                </label>
                <input type="submit">
            </form>
        </div>

    </div>

    <div class="rightSide">
        <a href="mainFeed.php">Back to main page</a>
    </div>

</div>