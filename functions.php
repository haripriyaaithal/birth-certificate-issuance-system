<?php

// Function to test user input
function testInput($input) {
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

// Function to display modal
function displayModal($title,$msg) {
    echo "
          <div id=\"modal1\" class=\"modal\">
          <div class=\"modal-content\">
            <h4>$title</h4>
            <p><h6>$msg</h6>
            </p>
          </div>
          <div class=\"modal-footer\">
            <a href=\"#!\" class=\" modal-action modal-close waves-effect waves-black btn-flat\">Ok</a>
          </div>
        </div>
         ";
}


