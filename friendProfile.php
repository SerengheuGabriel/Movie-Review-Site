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
    <div class="leftSide">
        <?php
        session_start();
        $_SESSION['mysqli'] = $mysqli = new mysqli("localhost", "root", "", "reviewpage");
        if (isset($_POST['friendUsername'])){
            $_SESSION['friendUsername'] = $_POST['friendUsername'];
        }
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

        ?>
    </div>

    <div class="middle">

        <div class="friendProfile">
            <?php
            if (isset($_POST['follow']) && !empty($_POST['follow'])) {
                $stmt = $_SESSION['mysqli']->prepare("SELECT * FROM followed WHERE theFollowerID = ? AND theFollowedID = ?");
                $stmt->bind_param("ii", $_SESSION['userID'], $_SESSION['friendID']);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 0) {
                    $stmt = $_SESSION['mysqli']->prepare("INSERT INTO followed(theFollowerID, theFollowedID) VALUES (?, ?)");
                    $stmt->bind_param("ii", $_SESSION['userID'], $_SESSION['friendID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                }
            }
            ?>

            <?php
                $stmt = $_SESSION['mysqli']->prepare("SELECT profilePicture, userID FROM users WHERE userName = ?");
                $stmt->bind_param("s", $_SESSION['friendUsername']);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                while ($row = $result -> fetch_assoc()) {
                    ?>
                    <img src="<?= $row['profilePicture'] ?>", width='100', height='100'>
                    <?php
                    $_SESSION['friendID'] = $row["userID"];
                    echo $_SESSION['friendUsername'];
                }

            ?>
            <br>
            <div class="followButton">
                <form method="post" action="">
                    <input type="submit" name="follow" value="Follow">
                </form>
            </div>
            <br>
            <div class="friendFeed">
        </div>
        <?php

            $stmt = $_SESSION['mysqli']->prepare("SELECT postText, movieID, score FROM reviews WHERE userID = ?");
            $stmt->bind_param("s", $_SESSION['friendID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            while ($row = $result -> fetch_assoc()) {
                ?>
                <div class="post">
                    <div class="postUserInfo">
                        <?php
                        $stmt1 = $_SESSION['mysqli']->prepare("SELECT userName, profilePicture FROM users WHERE userID = ?");
                        $stmt1->bind_param("i", $_SESSION['friendID']);
                        $stmt1->execute();
                        $answer1 = $stmt1->get_result();
                        $stmt1->close();

                        while ($rows1 = $answer1 -> fetch_assoc()){
                            ?>
                            <img src="<?= $rows1['profilePicture'] ?>" width="15%" height="15%">
                            <?= $rows1['userName'] ?>
                            <br>
                            <?= $row['score'] ?>
                            <img src="star.png" class="star">
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="postText">
                    <?= $row['postText'] ?>
                </div>
                <div class="postMovieInfo">

                    <?php

                    $stmt2 = $_SESSION['mysqli']->prepare("SELECT movieTitle, moviePic, movieReleaseYear FROM movies WHERE movieID = ?");
                    $stmt2->bind_param("i", $row['movieID']);
                    $stmt2->execute();
                    $answer2 = $stmt2->get_result();
                    $stmt2->close();

                    while ($rows2 = $answer2 -> fetch_assoc()) {
                        ?><img src="<?= $rows2['moviePic'] ?>" width="15%" height="15%">
                        <?= $rows2['movieTitle'] ?>
                        (<?= $rows2['movieReleaseYear'] ?>)
                        <?php
                    }
                    ?>

                </div>

                <?php

            }

        ?>
        </div>
    </div>

    <div class="rightSide">
        <a href="mainFeed.php">Back to main page</a>
    </div>

</div>