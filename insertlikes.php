<?php
require_once "config.php";
$dislike = $_POST['dislike'];


// Prepare an insert statement
$sql = "INSERT INTO `matches`(`matcher_id`, `matched_id`, `action`) VALUES (?,?,?)";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sss", $mathcer_id, $users_id, $action);

    // Set parameters
    $mathcer_id  = $_POST['id'];
    $users_id = $_POST['users_id'];
    $action = "";

    $like = $_POST['like'];
    $dislike = $_POST['dislike'];
    // Checking which action was selected then pass it to action column
    if (is_null($dislike)) {
        $action = $like;
    } else {
        $action = $dislike;
    }

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        header("location: login.php");
    }
    // Close statement
    mysqli_stmt_close($stmt);
}
