<?php
  // Unset cookies
  setcookie("admin_login_status", "logged_out", time(), "/"); // 86400 = 1 day
  setcookie("admin_user", "", time(), "/");
  // Redirect to login page
  echo "<script type=\"text/javascript\">window.location.href = 'index.php#adminLogin'; </script>";
