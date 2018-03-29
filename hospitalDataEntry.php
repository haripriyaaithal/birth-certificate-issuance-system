<!DOCTYPE html>
<html>
<head>
    <?php
    // Database connection
    require 'db.php';

    // Check user is logged in or not
    if(isset($_COOKIE['hospital_login_status']) == "logged_in") {
        // Set title to user's username
        echo "<title>".strtoupper($_COOKIE['hospital_user'])." - Home </title>";
    } else {
        // Redirect to login
        header('Location: index.php#hospitalDataEntry');
    }
    ?>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body class="grey lighten-4">

<!--Navigation bar -->
<nav>
    <div class="nav-wrapper light-blue accent-4">
        <a href="#" class="brand-logo center">Welcome <?php echo ucfirst($_COOKIE['hospital_user']) ?>!</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a class="waves-effect waves-light btn light-blue accent-4" href="hospitalLogout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class=" container">
    <div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" autocomplete="off" class="col s12 offset-s1">
            <div class="col s12 m9">
                <div class="card">
                    <div class="container">
                        <div class="row">
                            <div class="input-field col s11">
                                <input id="childID" type="text" name="childID" class="validate" required>
                                <label for="childID">Child ID</label>
                            </div>
                        </div>

                        <div class="row">
                            <h6>&nbsp;&nbsp;Gender</h6>
                                <p>
                                    &nbsp;&nbsp;<input name="gender" type="radio" id="male" value="Male"/>
                                    <label for="male">Male</label>

                                    <input name="gender" type="radio" id="female" value="Female"/>
                                    <label for="female">Female</label>

                                    <input name="gender" type="radio" id="other" value="Other" />
                                    <label for="other">Other</label>
                                </p>
                        </div>

                        <div class="row">
                            <div class="input-field col s11">
                                <input type="text" class="datepicker" name="date" placeholder="Date Of Birth">
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s11">
                                <input type="text" class="timepicker" name="time" placeholder="Time">
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s11">
                                <input id="fathersAadharNumber" name="fathersAadharNumber" type="text" maxlength="12" class="validate" required>
                                <label for="fathersAadharNumber">Father's Aadhar Number</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s11">
                                <input id="mothersAadharNumber" name="mothersAadharNumber" type="text" maxlength="12" class="validate" required>
                                <label for="mothersAadharNumber">Mother's Aadhar Number</label>
                            </div>
                        </div>

                        <button class="waves-effect waves-light btn light-blue accent-4 white-text" type="submit" name="submit">Submit</button>
                        <!-- space at the bottom of card -->
                        <div class="container">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--script for UI -->
<script type="text/javascript" src="jquery-3.2.1.min.js"></script>
<script src="materialize.min.js"></script>


<?php

// Contains functions to test user input and alert box
include 'functions.php';

// Aadhar sample database
$sql = "CREATE TABLE IF NOT EXISTS aadhar (
        aadharNo BIGINT PRIMARY KEY,
        name VARCHAR(20) NOT NULL,
        dob DATE NOT NULL,
        gender CHAR(6) NOT NULL,
        address VARCHAR(50) NOT NULL,
        phoneNumber BIGINT NOT NULL,
        email VARCHAR(30) NOT NULL,
        fathersAadharNo BIGINT DEFAULT NULL,
        mothersAadharNo BIGINT DEFAULT NULL,
        FOREIGN KEY (fathersAadharNo) REFERENCES aadhar(aadharNo) ON DELETE SET NULL,
        FOREIGN KEY (mothersAadharNo) REFERENCES aadhar(aadharNo) ON DELETE SET NULL
);";

if ($connection->query($sql)) {
    $sql = "INSERT IGNORE INTO aadhar 
            VALUES (123456789000, 'Akshay', '1980-10-20', 'male', 'Udupi', 9847859666, 'akshay@gmail.com', NULL, NULL),
                   (123456789001, 'Anushka', '1980-12-29', 'female', 'Udupi', 9847859666, 'anushka@gmail.com' ,NULL, NULL),
                    (123456789002, 'Shahrukh Khan', '1982-11-26', 'male', 'Manipal', 9862153668, 'khan@gmail.com', NULL, NULL),
                    (123456789003,' Deepika', '1982-12-12', 'female', 'Mangaluru', 9658745399, 'deepika@gmail.com', NULL, NULL);";

    $connection->query($sql);

}

if (isset($_POST['submit'])) {
    if (!(empty($_POST['childID']) || empty($_POST['gender'])  || empty($_POST['date']) || empty($_POST['time'])
        || empty($_POST['fathersAadharNumber']) || empty($_POST['mothersAadharNumber']))) {
       
        $childID = testInput($_POST['childID']);
        $gender = testInput($_POST['gender']);
        $dob = testInput($_POST['date']);
        $time = testInput($_POST['time']);
        $fathersAadharNumber = testInput($_POST['fathersAadharNumber']);
        $mothersAadharNumber = testInput($_POST['mothersAadharNumber']);

        $sql = "CREATE TABLE IF NOT EXISTS birth_details (
            childID INT PRIMARY KEY,
            gender CHAR(6) NOT NULL,
            dob VARCHAR(30) NOT NULL,
            time VARCHAR(5) NOT NULL,
            fAadharNumber BIGINT NOT NULL,
            mAadharNumber BIGINT NOT NULL,
            hospital VARCHAR(20) NOT NULL ,
            FOREIGN KEY (hospital) REFERENCES hospitals(username),
            FOREIGN KEY (fAadharNumber) REFERENCES aadhar(aadharNo),
            FOREIGN KEY (mAadharNumber) REFERENCES aadhar(aadharNo) 
        );";

        if ($connection->query($sql)) {
            $sql = "SELECT childID
                    FROM birth_details
                    WHERE hospital = ? AND 
                    childID = ?;";
            $result = $connection->prepare($sql);
            $result->bind_param('ss', $_COOKIE['hospital_user'], $childID);
            $result->execute();
            $result->store_result();

            if ($result->num_rows == 0) {
                $sql = "INSERT INTO birth_details 
                        VALUES (?, ?, ?, ?, ?, ?, ?);";
                $result = $connection->prepare($sql);
                $result->bind_param('sssssss', $childID, $gender, $dob, $time, $fathersAadharNumber,
                    $mothersAadharNumber, $_COOKIE['hospital_user']);

                if ($result->execute()) {
                    // Child details saved successfully
                    displayModal("Success", "Details of child id : ".$childID." saved successfully!");
                } else {
                    displayModal("Error", "Cannot insert details to the database<br><br>Make sure aadhar numbers of parents are correct and child ID should be unique.");
                }

            } else {
                // If child id already registered
                displayModal("Error", "Child ID : ".$childID." is already registered.");
            }

        } else {
            displayModal("Error", "Cannot create table".$connection->error);
        }

    } else {
        displayModal("Error", "Some variables are not set");
    }
}


?>


<?php
    // Close database connection
    $connection->close();
?>

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
        aftershow: function(){} //Function for after opening timepicker
    });

</script>


<!-- script to open modal -->
<script>
    $(document).ready(function(){
        $('#modal1').modal();
        $('#modal1').modal('open');
    });
</script>


</body>
</html>
