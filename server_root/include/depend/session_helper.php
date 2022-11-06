<?php
if (!isset($_SESSION))
{   session_start();    }

//If the session is invalid, kick the user back to the login page
if (empty($_SESSION['User_ID']))
{
    header("Location: index.php");
    exit("Sorry, the current session has expired.  Please log in again.");
}
?>
