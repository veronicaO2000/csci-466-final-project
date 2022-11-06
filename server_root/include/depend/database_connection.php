<?php

$username = "z1838776";
$password = "1999Dec02";

try
{
    $dsn = "mysql:host=courses;dbname=z1838776";
    $pdo = new PDO($dsn, $username, $password);
}

catch(PDOexception $exception_error)
{	echo "Connection to the database failed: " . $exception_error->getMessage();	}

?>
