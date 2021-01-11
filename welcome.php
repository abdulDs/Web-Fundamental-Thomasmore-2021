<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.">
    <title>Document</title>
    <link rel="stylesheet" href="../colorlib-regform-4/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"> </script>


<body>
    <h3 class="btn-outline-light " style="text-align: center; margin: 20px; margin-bottom: 20px;"></i><i class="fas fa-heart"></i> Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Love Website.</h3>
    <?php
    $preferred_gender = $_SESSION['prefgender'];
    $user_id = $_SESSION['id'];
    // fetching all needed rows from db.
    $rows = GetQuery("SELECT * from user where id not in (select matched_id from matches where matcher_id ='$user_id') and gender='$preferred_gender' and id != '$user_id'");

    ?>
    <!-- Create a card -->
    <?php foreach ($rows as $row) { ?>
        <div class="was-active">
            <div class="card">
                <img class="card-img-top" src="https://placeimg.com/600/300/people" alt="Card image cap"><br>
                <div class="rowcard-body">
                    <h5 class="card-title"><?php echo  $row["firstname"] . " " . $row["lastname"] . ", " . $row["age"] ?></h5><br>
                    <p class="card-text"><?php echo $row["bio"] ?></p><br>
                </div>
                <div class="footer text-center">
                    <form action="./insertlikes.php" method="post">
                        <input type="hidden" name="users_id" value=<?php echo $row['id']; ?> />
                        <input type="hidden" name="id" value=<?php echo $_SESSION['id']; ?> />
                        <input type="hidden" name="like" value="1">
                        <div class="tinder--buttons">
                            <button itype="submit" class="btnlike1" id="love"><i class="fa fa-heart"></i></button>
                        </div>
                    </form>
                    <form action="./insertlikes.php" method="post">
                        <input type="hidden" name="users_id" value=<?php echo $row['id']; ?> />
                        <input type="hidden" name="id" value=<?php echo $_SESSION['id']; ?> />
                        <input type="hidden" name="dislike" value="0">
                        <div class="tinder--buttons">
                            <button id="nope" type="submit" class=" btnlike1"> <i class="fas fa-thumbs-down"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    ?>



    <div class="btn-outline-light was-active" style="text-align: center;">
        <?php
        // select all users liked
        $user_id = $_SESSION['id'];
        $data = GetQuery("SELECT * from user where id in (select matched_id from matches where matcher_id = $user_id and action = 1)");
        ?>
        <h4>Liked</h4>
        <?php foreach ($data as $row) { ?>
            <p> <?php echo  $row["firstname"] . " " . $row["lastname"] . ", " . $row["age"] ?> </p>
        <?php
        }
        ?>

        <?php
        $user_id = $_SESSION['id'];
        // select all unliked useres 
        $data = GetQuery("SELECT * from user where id in (select matched_id from matches where matcher_id = $user_id and action = 0)");
        ?>
        <h4>Disliked</h4>
        <?php foreach ($data as $row) { ?>
            <?php echo  $row["firstname"] . " " . $row["lastname"] . ", " . $row["age"] ?>
        <?php
        }
        ?>
    </div>

    <div class="btn-group mt-2 mb-4" role="group" aria-label="actionButtons">
        <a href="reset-password.php" class="d-block btn btn-outline-light">Reset Your Password</a>
        <a href="logout.php" class="d-block btn btn-outline-light">Sign Out </a>
    </div>
    <script src="../colorlib-regform-4/js/tindercard.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" integrity="sha256-qM7QTJSlvtPSxVRjVWNM2OfTAz/3k5ovHOKmKXuYMO4=" crossorigin="anonymous"></script>
</body>

</html>