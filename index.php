<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $gender = $prefgender = $age = $bio = "";
$username_err = $password_err = $confirm_password_err = $firstname_err = $gender_err = $prefgender_err = $age_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE username = ?";
        // if the id dose not exist in out table
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    // Validate firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter firstname.";
    } else {

        $firstname = trim($_POST["firstname"]);
    }

    // Validate lastname
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter lastname.";
    } else {

        $lastname = trim($_POST["lastname"]);
    }
    // Validate gender
    if (empty(trim($_POST["gender"]))) {
        $gender_err = "Please select your gender.";
    } else {

        $gender = trim($_POST["gender"]);
    }
    // Validate preferred gender
    if (empty(trim($_POST["prefgender"]))) {
        $prefgender_err = "Please select preferred gender.";
    } else {

        $prefgender = trim($_POST["prefgender"]);
    }
    // Validate age
    if (empty(trim($_POST["age"]))) {
        $age_err = "Please enter your age.";
    } elseif (!is_numeric(trim($_POST["age"]))) {
        $age_err = "Please type a number y.";
    } else if (trim($_POST["age"]) <= 17) {

        $age_err = "you are still young for this kinde of websites go watch cartoon.";
    } else {
        $age = trim($_POST["age"]);
    }

    // Validate Bio
    if (empty(trim($_POST["bio"]))) {
        $bio = trim($_POST["bio"]);
    } else {
        $bio = trim($_POST["bio"]);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($gender_err) && empty($prefgender_err) && empty($age_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO user (username, password, firstname, lastname, gender, prefgender, age, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_username, $param_password, $param_firstname, $param_lastname, $param_gender, $param_prefgender, $param_age, $param_bio);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_gender = $gender;
            $param_prefgender = $prefgender;
            $param_age = $age;
            $param_bio = $bio;


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Abdul's Love website</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="colorlib-regform-4/css/main.css" rel="stylesheet" media="all">
    <style>
        body {
            font: size 50px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Registration Form</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                                    <label class="label">Fist Name</label>
                                    <input class="input--style-4" type="text" name="firstname" value="<?php echo $firstname; ?>">
                                    <span class="help-block"><?php echo $firstname_err; ?></span>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                                    <label class="label">Last Name</label>
                                    <input class="input--style-4" type="text" name="lastname" value="<?php echo $lastname; ?>">
                                    <span class="help-block"><?php echo $lastname_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <label class="label">User Name</label>
                                    <input class="input--style-4" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                                    <span class="help-block"><?php echo $username_err; ?></span>
                                </div>

                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <label class="label">Passoword</label>
                                    <input class="input--style-4" type="password" name="password" value="<?php echo $password; ?>">
                                    <span class="help-block"><?php echo $password_err; ?></span>

                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Confirm Passoword</label>
                                    <input class="input--style-4" type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                                    <label class="label">Gender</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio" checked="checked" name="gender" value="m">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" name="gender" value="f">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                                    <label class="label">Age</label>
                                    <input class="input--style-4" type="number" name="age" min="18" max="100" value="<?php echo $age; ?>">
                                    <span class="help-block"><?php echo $age_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group  <?php echo (!empty($prefgender_err)) ? 'has-error' : ''; ?>">
                            <label class="label">Preferrd Gender</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="prefgender" value="<?php echo $prefgender; ?>">
                                    <option selected disabled>Select here</option>
                                    <option value="m">Male</option>
                                    <option value="f">Female</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="lable">Bio</label>
                                    <textarea class="input--style-4" type="text" name="bio" value="<?php echo $bio; ?>"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="p-t-15">
                            <input class="btn btn--radius-2 btn--blue" type="submit" value="submit">
                        </div>
                        <p>Already have an account? <a href="login.php">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="./colorlib-regform-4/js/global.js"></script>

</body>
<!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->