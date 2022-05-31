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
                if ($_SESSION['userID'] == 4) {
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

        <br>



        <div class="createPost">
        <form autocomplete="off" method="post" action="">
            <div class="autocomplete" style="width:300px;">
                <input id="myInput" type="text" name="myCountry" placeholder="Search for Movie" required="required">
            </div>
            <br>
            <label for="description">Write a review:</label>
            <textarea rows="5" class="form-control" name="postText" maxlength="255"></textarea>
            <select name="score" id="score" required="required">
                <option value="1">1 / 5</option>
                <option value="2">2 / 5</option>
                <option value="3">3 / 5</option>
                <option value="4">4 / 5</option>
                <option value="5">5 / 5</option>
            </select>
            <input type="submit" name="button" value="Post">
        </form>
        </div>

        <?php
        if (isset($_POST['button']) && !empty($_POST['button'])) {
                $stmt = $_SESSION['mysqli']->prepare("SELECT movieID FROM movies WHERE movieTitle = ?");
                $stmt->bind_param("s", $_POST['myCountry']);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                while ($row = $result->fetch_assoc()) {
                    $_SESSION['movieID'] = $row['movieID'];
                }

                $stmt = $_SESSION['mysqli']->prepare("SELECT * FROM reviews WHERE userID = ? AND movieID = ?");
                $stmt->bind_param("ii",  $_SESSION['userID'], $_SESSION['movieID']);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows == 0) {
                    $stmt = $_SESSION['mysqli']->prepare("INSERT INTO reviews(postText, movieID, userID, score) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("siii", $_POST["postText"], $_SESSION['movieID'], $_SESSION['userID'], $_POST['score']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                }
        }
        ?>


        <div class="feed">
            <br>
            <?php
            $stmt = $mysqli->prepare("SELECT theFollowerID, theFollowedID FROM followed where theFollowerID = ?");
            $stmt->bind_param("i", $_SESSION['userID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $followedIDs = [];

            while ($row = $result -> fetch_assoc()) {
                array_push($followedIDs,$row['theFollowedID']);
            }

            array_push($followedIDs,$_SESSION['userID']);

            $i = 0;
            while ($i < count($followedIDs)){
                $stmt = $_SESSION['mysqli']->prepare("SELECT postText, movieID, score FROM reviews WHERE userID = ?");
                $stmt->bind_param("i", $followedIDs[$i]);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                while ($row = $result -> fetch_assoc()) {
                    ?>
                    <br>
                    <div class="post">
                        <div class="postUserInfo">
                            <?php
                            $stmt1 = $_SESSION['mysqli']->prepare("SELECT userName, profilePicture FROM users WHERE userID = ?");
                            $stmt1->bind_param("i", $followedIDs[$i]);
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
                    </div>
                    <?php

                }
                $i++;
            }

            ?>

        </div>

    </div>

    <div class="rightSide">

        <div class="following">
            Following
            <?php
            $stmt = $mysqli->prepare("SELECT theFollowerID, theFollowedID FROM followed where theFollowerID = ?");
            $stmt->bind_param("i", $_SESSION['userID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $followedIDs = [];

            while ($row = $result -> fetch_assoc()) {
                array_push($followedIDs,$row['theFollowedID']);
            }

            $i = 0;
            while ($i < count($followedIDs)){
                $stmt = $_SESSION['mysqli']->prepare("SELECT userName, userID FROM users where userID = ?");
                $stmt->bind_param("i", $followedIDs[$i]);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                while ($row = $result -> fetch_assoc()){
                    ?>
                    <form method="post" action="friendProfile.php">
                        <input type="submit" value="<?= $row['userName'] ?>" name="friendUsername" class="recommendedFriends">
                    </form>
                    <br>
                    <?php
                }
                $i++;
            }

            ?>
        </div>
        <div class="recommended">
            Recommended<br>
            <?php
                $stmt = $mysqli->prepare("SELECT userName FROM users where userID != ? EXCEPT SELECT users.userName FROM users INNER JOIN followed ON users.userID = followed.theFollowedID WHERE followed.theFollowerID = ?;");
                $stmt->bind_param("ii", $_SESSION['userID'], $_SESSION['userID']);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                while ($row = $result -> fetch_assoc()){
                    ?>
                    <form method="post" action="friendProfile.php">
                    <input type="submit" value="<?= $row['userName'] ?>" name="friendUsername" class="recommendedFriends">
                    </form>
                    <br>
                    <?php
                }

            ?>

        </div>
    </div>

</div>


<?php

    $stmt = $mysqli->prepare("SELECT movieTitle FROM movies");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while ($row = $result -> fetch_assoc()){
        $res[] = $row['movieTitle'];
    }

?>

    <script>

        var res = <?php echo json_encode($res); ?>;

        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        autocomplete(document.getElementById("myInput"), res);
</script>