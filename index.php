<?php
ob_start(); // Initiate the output buffer to avoid header problem while redirecting

// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>BCIS</title>
    <?php
    // Database connection
    require 'db.php';

    ?>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!--script for UI -->
    <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
    <script src="materialize.min.js"></script>

</head>
<body class="grey lighten-4">

<?php

// Create city to store the details of cities
$sql = "CREATE TABLE IF NOT EXISTS city (
        cityID INT PRIMARY KEY,
		cityName VARCHAR(20) NOT NULL UNIQUE 
        );";

if ($connection->query($sql)) {
    $sql = "INSERT IGNORE INTO city VALUES
            (1, 'Bangalore'),
            (2, 'Bellary'),
            (3, 'Bidar'),
            (4, 'Bijapur'),
            (5, 'Chikmagalur'),
            (6, 'Chitiradurga'),
            (7, 'Davangere'),
            (8, 'Gulbarga'),
            (9, 'Hassan'),
            (10, 'Hospet'),
            (11, 'Hubli'),
            (12, 'Karwar'),
            (13, 'Madikeri'),
            (14, 'Mangalore'),
            (15, 'Manipal'),
            (16, 'Mysore'),
            (17, 'Raichur'),
            (18, 'Shimoga'),
            (19, 'Sringeri'),
            (20, 'Srirangapatna'),
            (21, 'Tumkur'),
            (22, 'Udupi');";
    $connection->query($sql);
}


?>

<!--Navigation bar -->
<nav class="nav-extended light-blue accent-4">

    <div class="nav-wrapper">
        <a href="#" class="brand-logo center">Birth Certificate Issuance System</a>
    </div>

    <div class="nav-content">
        <!-- tabs -->
        <ul class="tabs tabs-transparent">
            <li class="tab">
                <a class="active" href="#addAdmin">Add Admin</a>
            </li>
            <li class="tab">
                <a href="#adminLogin">Admin Login</a>
            </li>
            <li class="tab">
                <a href="#hospitalDataEntry">Hospital Login</a>
            </li>
            <li class="tab">
                <a href="#requestCertificate">Birth Certificate Request Page</a>
            </li>
        </ul>
    </div>
</nav>

<!-- First Tab -->
<div id="addAdmin" class="col s12">
    <div class="container">
        <div class="row">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off"
                  class="col s12 offset-s1">
                <div class="col s12 m9">
                    <div class="card">
                        <div class="container">

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="username" type="text" name="addAdminUsername" class="validate" required>
                                    <label for="username">Admin Username</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="password" type="password" name="addAdminPassword" class="validate"
                                           required>
                                    <label for="password">Password</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="confirmPassword" type="password" name="addAdminConfirmPassword"
                                           class="validate" required>
                                    <label for="confirmPassword">Confirm Password</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="email" type="email" name="addAdminEmail" class="validate" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>

                            <!-- Script for material design select -->
                            <script>
                                $(document).ready(function () {
                                    $('select').material_select();
                                });
                            </script>

                            <div class="row">

                                <?php
                                // Get all cities from city table
                                $sql = "SELECT * FROM city;";
                                $result = $connection->query($sql);

                                if ($result->num_rows > 0) {
                                    // Print all city to select tag
                                    echo "  <div class=\"input-field col s11\">
                                               <select name=\"addAdminCity\">
                                               <option value = \"default\" selected>Select City</option>";

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value=\"" . $row["cityID"] . "\">" . ucfirst($row["cityName"]) . "</option>";
                                    }

                                    echo "</select>
                                                    <label>City</label>
                                                  </div>";

                                } else {

                                    echo "  <div class=\"input-field col s11\">
                                               <select name=\"cityID\">
                                               <option value = \"default\" disabled>Cannot get city from database</option>
                                               </select>";

                                }
                                ?>
                                <button class="waves-effect waves-light btn light-blue accent-4 white-text"
                                        type="submit" name="addAdminSubmit">Create Admin Account
                                </button>

                                <!-- Space at the bottom of card -->
                                <div class="container">
                                    &nbsp;
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Second Tab -->
<div id="adminLogin" class="col s12">
    <div class="container">
        <div class="row">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off"
                  class="col s12 offset-s1">
                <div class="col s12 m9">
                    <div class="card">
                        <div class="container">

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="username" type="text" name="adminLoginUsername" class="validate"
                                           required>
                                    <label for="username">Admin Username</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="password" type="password" name="adminLoginPassword" class="validate"
                                           required>
                                    <label for="password">Password</label>
                                </div>
                            </div>

                            <button class="waves-effect waves-light btn light-blue accent-4 white-text" type="submit"
                                    name="adminLoginSubmit">Login
                            </button>

                            <!-- Space at the bottom of card -->
                            <div class="container">
                                &nbsp;
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Third Tab -->
<div id="hospitalDataEntry" class="col s12">
    <div class="container">
        <div class="row">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off"
                  class="col s12 offset-s1">
                <div class="col s12 m9">
                    <div class="card">
                        <div class="container">

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="hospitalUserName" name="hospitalUserName" type="text" class="validate"
                                           required>
                                    <label for="hospitalUserName">Hospital Username</label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="hospitalPassword" name="hospitalPassword" type="password"
                                           class="validate" required>
                                    <label for="hospitalPassword">Password</label>
                                </div>
                            </div>

                            <button class="waves-effect waves-light btn light-blue accent-4 white-text" type="submit"
                                    name="hospitalLoginSubmit">Login
                            </button>

                            <!-- Space at the bottom of card -->
                            <div class="container">
                                &nbsp;
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fourth Tab -->
<div id="requestCertificate" class="col s12">
    <div class="container">
        <div class="row">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off"
                  class="col s12 offset-s1">
                <div class="col s12 m9">
                    <div class="card">
                        <div class="container">

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="childID" name="childID" type="number" class="validate" required>
                                    <label for="childID">Child ID</label>
                                </div>
                            </div>

                            <div class="row">
                                <?php
                                // Get all username of hospitals
                                $sql = "SELECT username
                                            FROM hospitals";
                                $result = $connection->query($sql);

                                if ($result->num_rows > 0) {
                                    // Print all hospitalID to select tag
                                    echo "  <div class=\"input-field col s11\">
                                           <select name=\"hospitalID\">
                                           <option value = \"default\" selected>Select Hospital</option>";

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value=\"" . $row["username"] . "\">" . strtoupper($row["username"]) . "</option>";
                                    }

                                    echo "</select>
                                                <label>Hospital ID</label>
                                              </div>";

                                } else {

                                    echo "  <div class=\"input-field col s11\">
                                           <select name=\"hospitalID\">
                                           <option value = \"default\" disabled>Cannot get hospitals from database</option>
                                           </select>";

                                }
                                ?>
                            </div>


                            <div class="row">
                                <h6>&nbsp;&nbsp;Gender</h6>
                                <p>
                                    &nbsp;&nbsp;<input name="gender" type="radio" id="male" value="Male" required/>
                                    <label for="male">Male</label>

                                    <input name="gender" type="radio" id="female" value="Female" required/>
                                    <label for="female">Female</label>

                                    <input name="gender" type="radio" id="other" value="Other" required/>
                                    <label for="other">Other</label>
                                </p>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <label>Date</label>
                                    <input type="text" class="datepicker" name="date" placeholder="Date Of Birth"
                                           required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <label>Time</label>
                                    <input type="text" class="timepicker" name="time" placeholder="Time" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="childName" name="childName" type="text" class="validate" required>
                                    <label for="childName">Child Name</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <textarea id="address" name="address" class="materialize-textarea"></textarea>
                                    <label for="address">Permanent address of parents</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="fathersAadharNumber" name="fathersAadharNumber" type="text"
                                           maxlength="12" class="validate" required>
                                    <label for="fathersAadharNumber">Father's Aadhar Number</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11">
                                    <input id="mothersAadharNumber" name="mothersAadharNumber" type="text"
                                           maxlength="12" class="validate" required>
                                    <label for="mothersAadharNumber">Mother's Aadhar Number</label>
                                </div>
                            </div>

                            <button class="waves-effect waves-light btn light-blue accent-4 white-text" type="submit"
                                    name="birthCertificateRequest">Request Birth Certificate
                            </button>

                            <!-- Space at the bottom of card -->
                            <div class="container">
                                &nbsp;
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

// Contains functions to test user input and alert box
include 'functions.php';

/*
 * addAdmin php
 *
 */

if (isset($_POST['addAdminSubmit'])) {
    if (!(empty($_POST['addAdminUsername']) || empty($_POST['addAdminPassword']) || empty($_POST['addAdminConfirmPassword']) ||
        empty($_POST['addAdminCity']))) {

        $username = testInput($_POST['addAdminUsername']);
        $password = testInput($_POST['addAdminPassword']);
        $confirmPassword = testInput($_POST['addAdminConfirmPassword']);
        $email = testInput($_POST['addAdminEmail']);
        $cityID = testInput($_POST['addAdminCity']);

        if ($password == $confirmPassword) {
            // Create table to store admin login info
            $sql = "CREATE TABLE IF NOT EXISTS city_admin (
				username VARCHAR(20) PRIMARY KEY,
				password VARCHAR(60) NOT NULL,
				email VARCHAR(50) NOT NULL,
				cityID INT NOT NULL UNIQUE,
				FOREIGN KEY (cityID) REFERENCES city(cityID)
			);";

            if ($connection->query($sql)) {
                // Check if city is selected
                if ($cityID == "default") {
                    displayModal("Error", "Please select the city");
                    echo "<script type=\"text/javascript\"> window.location.href = 'index.php#addAdmin'; </script>";
                } else {
                    // Check if user is registered or not
                    $sql = "SELECT `username`
                            FROM `city_admin` 
                            WHERE `username`=?;";
                    $result = $connection->prepare($sql);
                    $result->bind_param('s', $username);
                    $result->execute();
                    $result->store_result();

                    if ($result->num_rows == 0) { // If not registered
                        // Insert admin info to the table
                        // Hash password before storing it in db
                        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                        $sql = "INSERT INTO `city_admin` (`username`, `password`, `email`, `cityID`)
                                VALUES(?, ?, ?, ?);";
                        $result = $connection->prepare($sql);
                        $result->bind_param('sssi', $username, $password, $email, $cityID);

                        if ($result->execute()) {
//                            // Send email
//                            $subject = "BCIS - Account created successfully!";
//                            $emailBody = "Dear $username,\n\nYour account has been created successfully!.";
//                            mail($email, $subject, $emailBody, "From: no-reply@bcis.com");

                            // Alert success and redirect
                            displayModal("Success", $username . " added successfully!");
                        } else {
                            displayModal("Error", "Cannot add " . $username . "<br>" . $connection->error);
                        }
                    } else {
                        // If user already registered
                        displayModal("Error", "$username is already registered!");
                    }
                }
            } else {
                //  If table cannot be created
                displayModal("Error", "Error occurred while creating table<br>" . $connection->error);
            }
        } else {
            // If both password didn't match
            displayModal("Error", "Passwords don't match!");
        }
    } else {
        displayModal("Error", "Please enter all the fields");
    }
}


/*
 * adminLogin php
 *
 */

// When adminLoginSubmit button clicked
if (isset($_POST['adminLoginSubmit'])) {
    if (!(empty($_POST['adminLoginUsername']) || empty($_POST['adminLoginPassword']))) {
        $username = testInput($_POST['adminLoginUsername']);
        $password = testInput($_POST['adminLoginPassword']);

        // Check if username and password is correct
        $sql = "SELECT `password`
                FROM `city_admin`
                WHERE `username`=?;";
        $result = $connection->prepare($sql);
        $result->bind_param('s', $username);

        if ($result->execute()) {
            $result->store_result();

            // Store result in $storedPassword variable
            $result->bind_result($storedPassword);
            $result->fetch();

            if (password_verify($password, $storedPassword)) {
                // Success
                setcookie("admin_login_status", "logged_in", time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie("admin_user", $username, time() + (86400 * 30), "/");
                // Redirect to addHospital page
                echo "<script type=\"text/javascript\"> window.location.href = 'addHospitals.php'; </script>";
            } else {
                // Failure
                displayModal("Problem Signing in", "Username or Password incorrect!");
                echo "<script type=\"text/javascript\"> window.location.href = 'index.php#adminLogin'; </script>";
            }
        } else {
            // Failure
            displayModal("Error", "Username doesn't exists!");
            echo "<script type=\"text/javascript\">window.location.href = 'index.php#adminLogin'; </script>";
        }

    } else {
        displayModal("Error", "Problem getting data from user");
        echo "<script type=\"text/javascript\"> window.location.href = 'index.php#adminLogin'; </script>";
    }
}


/*
 * hospitalLogin php
 *
 */

// When hospitalLoginSubmit button clicked
if (isset($_POST['hospitalLoginSubmit'])) {
    if (!(empty($_POST['hospitalUserName']) || empty($_POST['hospitalPassword']))) {
        $username = testInput($_POST['hospitalUserName']);
        $password = testInput($_POST['hospitalPassword']);

        // Check if username and password is correct
        $sql = "SELECT `password`
                FROM `hospitals` 
                WHERE `username`=?;";
        $result = $connection->prepare($sql);
        $result->bind_param('s', $username);

        if ($result->execute()) {
            $result->store_result();

            // Store result in $storedPassword variable
            $result->bind_result($storedPassword);
            $result->fetch();

            if (password_verify($password, $storedPassword)) {
                // Success
                setcookie("hospital_login_status", "logged_in", time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie("hospital_user", $username, time() + (86400 * 30), "/");
                // Redirect to hospitalDataEntry page
                echo "<script type=\"text/javascript\"> window.location.href = 'hospitalDataEntry.php'; </script>";
            } else {
                // Password don't match
                displayModal("Problem Signing in", "Username or Password incorrect!");
                echo "<script type=\"text/javascript\"> window.location.href = 'index.php#hospitalDataEntry'; </script>";
            }
        } else {
            // Failure
            displayModal("Error", "Username doesn't exists!");
            echo "<script type=\"text/javascript\">window.location.href = 'index.php#hospitalDataEntry'; </script>";
        }

    } else {
        displayModal("Error", "Problem getting data from user");
        echo "<script type=\"text/javascript\"> window.location.href = 'index.php#hospitalDataEntry'; </script>";

    }
}


/*
 * birth certificate request page php
 *
 */

// When birthCertificateRequest button clicked
if (isset($_POST['birthCertificateRequest'])) {
    if (!(empty($_POST['childID']) || empty($_POST['hospitalID']) || empty($_POST['gender']) || empty($_POST['date']) ||
        empty($_POST['time']) || empty($_POST['childName']) || empty($_POST['fathersAadharNumber']) ||
        empty($_POST['mothersAadharNumber']))) {

        $childID = testInput($_POST['childID']);
        $hospitalID = testInput($_POST['hospitalID']);
        $gender = testInput($_POST['gender']);
        $date = testInput($_POST['date']);
        $time = testInput($_POST['time']);
        $childName = testInput($_POST['childName']);
        $fathersAadharNumber = testInput($_POST['fathersAadharNumber']);
        $mothersAadharNumber = testInput($_POST['mothersAadharNumber']);
        $address = testInput($_POST['address']);

        // Check if hospital is selected or not
        if ($hospitalID == "default") {
            displayModal("Error", "Please select the Hospital");
            echo "<script type=\"text/javascript\"> window.location.href = 'index.php#requestCertificate'; </script>";
        } else {
            // Check if child is registered
            $sql = "SELECT childID
                FROM birth_details
                WHERE childID = ? AND
                      gender = ? AND
                      dob = ? AND
                      time = ? AND
                      fAadharNumber = ? AND
                      mAadharNumber = ? AND 
                      hospital = ?";
            $result = $connection->prepare($sql);
            $result->bind_param('issssss', $childID, $gender, $date, $time, $fathersAadharNumber,
                $mothersAadharNumber, $hospitalID);

            if ($result->execute()) {
                $result->store_result();
                if ($result->num_rows == 1) {
                    // If entered details are correct, generate the birth certificate pdf
                    // Get father's name
                    $sql = "SELECT name
                            FROM aadhar
                            WHERE aadharNo = ?";
                    $result = $connection->prepare($sql);
                    $result->bind_param('s', $fathersAadharNumber);
                    $result->execute();

                    // Get result from database
                    $res = $result->get_result();

                    // Convert it to associative array and get the name
                    $row = $res->fetch_assoc();
                    $father = $row['name'];

                    // Get mother's name
                    $sql = "SELECT name
                            FROM aadhar
                            WHERE aadharNo = ?";
                    $result = $connection->prepare($sql);
                    $result->bind_param('s', $mothersAadharNumber);
                    $result->execute();

                    // Get result from database
                    $res = $result->get_result();

                    // Convert it to associative array and get the name
                    $row = $res->fetch_assoc();
                    $mother = $row['name'];

                    // Get city
                    $sql = "SELECT city.cityName
                            FROM hospitals, city
                            WHERE hospitals.cityID = city.cityID AND 
                                  username = ?";
                    $result = $connection->prepare($sql);
                    $result->bind_param('s', $hospitalID);
                    $result->execute();

                    // Get result from database
                    $res = $result->get_result();

                    // Convert it to associative array and get the name
                    $row = $res->fetch_assoc();
                        $city = $row['cityName'];

                    // Store the details in session array which is used to generate pdf
                    $_SESSION["hospital"] = strtoupper($hospitalID);
                    $_SESSION["name"] = $childName;
                    $_SESSION["gender"] = $gender;
                    $_SESSION["dob"] = $date;
                    $_SESSION["city"] = $city;
                    $_SESSION["fName"] = $father;
                    $_SESSION["mName"] = $mother;
                    $_SESSION["address"] = $address;

                    // Generate pdf
                    header('Location: pdf.php');
                } else {
                    // If details not found
                    displayModal("Error", "Data entered is not correct.");
                    echo "<script type=\"text/javascript\"> window.location.href = 'index.php#requestCertificate'; </script>";
                }
            } else {
                displayModal("Error", "Problem getting data from database");
                echo "<script type=\"text/javascript\"> window.location.href = 'index.php#requestCertificate'; </script>";
            }
        }

    } else {
        // Error getting data
        displayModal("Error", "Problem getting data from user");
        echo "<script type=\"text/javascript\"> window.location.href = 'index.php#requestCertificate'; </script>";
    }
}


?>

<?php
// Close database connection
$connection->close();
?>

<!-- if logged in, then redirect to respective pages -->
<script type="text/javascript">
    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    $('a[href="#adminLogin"]').click(function () {

        var cookie_value = readCookie('admin_login_status');
        if (cookie_value === 'logged_in') {
            window.location = "addHospitals.php";
        }
    });
    $('a[href="#hospitalDataEntry"]').click(function () {

        var cookie_value = readCookie('hospital_login_status');
        if (cookie_value === 'logged_in') {
            window.location = "hospitalDataEntry.php";
        }
    });
</script>

<!--script for date and time picker -->
<script>
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false // Close upon selecting a date,
    });

    $('.timepicker').pickatime({
        default: 'now', // Set default time: 'now', '1:30AM', '16:30'
        fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Clear', // text for clear-button
        canceltext: 'Cancel', // Text for cancel-button
        autoclose: false, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
        aftershow: function () {
        } //Function for after opening timepicker
    });

</script>

<!-- script to open modal -->
<script>
    $(document).ready(function () {
        $('.modal').modal();
        $('#modal1').modal('open');

    });
</script>

</body>
</html>