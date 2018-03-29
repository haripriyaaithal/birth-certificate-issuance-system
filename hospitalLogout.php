<?php
// Unset cookies
setcookie("hospital_login_status", "logged_out", time(), "/"); // 86400 = 1 day
setcookie("hospital_user", "", time(), "/");
// Redirect to login page
echo "<script type=\"text/javascript\">window.location.href = 'index.php#hospitalDataEntry'; </script>";
