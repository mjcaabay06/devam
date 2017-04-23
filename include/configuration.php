<?php
/** the Database Information **/
$hostname = 'localhost';
$username = 'root';
$password = 'mvc456$';
$dbname = 'devam_db';
$driver = 'mysql';
try{
    $dbh = new PDO("{$driver}:host={$hostname};dbname={$dbname}", $username, $password, array());
}catch(PDOException $e){
    die($e->getMessage());
}
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

$errorMessage = "";
?>