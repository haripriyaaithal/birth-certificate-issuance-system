<!DOCTYPE html>
<html>
	<head>
		<?php
            // Database connection
            require 'db.php';

             // Check user is logged in or not
             if(isset($_COOKIE['admin_login_status']) == "logged_in") {
               // Set title to user's username
               echo "<title>".ucfirst($_COOKIE['admin_user'])." - Home </title>";
             } else {
               // Redirect to login
               header('Location: index.php#adminLogin');
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
        <a href="#" class="brand-logo center">Welcome <?php echo ucfirst($_COOKIE['admin_user']) ?>!</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a class="waves-effect waves-light btn light-blue accent-4" href="adminLogout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" autocomplete="off" class="col s12 offset-s1">
            <div class="col s12 m9">
                <div class="card">
                    <div class="container">
                        <div class="row">
                            <div class="input-field col s11">
                                <input id="hospitalUsername" type="text" name="addHospitalUsername" class="validate" required autofocus>
                                <label for="hospitalUsername">Hospital Username</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s11">
                                <input id="hospitalAdminEmail" type="email" name="addHospitalEmail" class="validate" required>
                                <label for="hospitalAdminEmail">Hospital Admin Email</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s11">
                                <input id="hospitalPassword" type="password" name="addHospitalPassword" class="validate" required>
                                <label for="hospitalPassword">Hospital Password</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s11">
                                <input id="hospitalConfirmPassword" type="password" name="addHospitalConfirmPassword" class="validate" required>
                                <label for="hospitalConfirmPassword">Confirm Password</label>
                            </div>
                        </div>

                        <button class="waves-effect waves-light btn light-blue accent-4 white-text" type="submit" name="createHospitalSubmit">Create Hospital Account</button>
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

if (isset($_POST['createHospitalSubmit'])) {
    if (!(empty($_POST['addHospitalUsername']) || empty($_POST['addHospitalEmail'])  || empty($_POST['addHospitalPassword'])
        || empty($_POST['addHospitalConfirmPassword']))) {

        $username = testInput($_POST['addHospitalUsername']);
        $email = testInput($_POST['addHospitalEmail']);
        $password = testInput($_POST['addHospitalPassword']);
        $confirmPassword = testInput($_POST['addHospitalConfirmPassword']);

        if ($password == $confirmPassword) {
            // Table to store hospitals login info
            $sql = "CREATE TABLE IF NOT EXISTS hospitals (
              username VARCHAR(20),
              email VARCHAR(50) NOT NULL,
              password VARCHAR(60) NOT NULL,
              cityID INT NOT NULL,
              FOREIGN KEY (cityID) REFERENCES city_admin(cityID) ON DELETE CASCADE,
              PRIMARY KEY(username,cityID)
          );";

            if ($connection->query($sql)) {
                // Check if user already registered or not
                $sql = "SELECT `username` 
                        FROM `hospitals`
                        WHERE `username` = ?;";
                $result = $connection->prepare($sql);
                $result->bind_param('s', $username);
                $result->execute();
                $result->store_result();

                if ($result->num_rows == 0) { // If not registered
                    // Get city
                    $sql = "SELECT `cityID`
                            FROM `city_admin`
                            WHERE `username` = ?;";
                    $result = $connection->prepare($sql);
                    $result->bind_param('s', $_COOKIE['admin_user']);
                    $result->execute();

                    // Get result from database
                    $res = $result->get_result();

                    // Convert it to associative array and get the city
                    $row = $res->fetch_assoc();
                    $cityID = $row['cityID'];

                    // Hash password before storing it in db
                    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                    // SQL query to insert
                    $sql = "INSERT INTO `hospitals` (`username`, `email`, `password`, `cityID`)
                            VALUES (?, ?, ?, ?);";
                    $result = $connection->prepare($sql);
                    $result->bind_param('sssi', $username, $email, $password, $cityID);

                    // Insert into table
                    if ($result->execute()) {
                        displayModal("Success", "$username added successfully!");
//                        // Send email
//                        $subject = "BCIS - Hospital account created successfully!";
//                        $emailBody = "Dear $username,\n\nYour account has been created successfully!.";
//                        mail ($email, $subject, $emailBody);
                    } else {
                        // Failed to insert
                        displayModal("Error", "Cannot add ".$username."<br>Error : ".$connection->error);
                    }
                } else {
                    // If user already registered
                    displayModal("Error", "$username is already registered!");
                }

            } else {
                displayModal("Error", "Error occurred while creating table <br>".$connection->error);
            }

        } else {
            // If both password didn't match
            displayModal("Error", "Passwords don't match!");
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

<!-- Script to open modal -->
<script>
    $(document).ready(function(){
        $('#modal1').modal();
        $('#modal1').modal('open');
    });
</script>


</body>
</html>
