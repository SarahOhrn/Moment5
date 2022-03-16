<?php
include("includes/config.php");

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if($db->connect_errno>0){
    die ('Fel vid anslutning ['. $db->connect_error . ']');
}

$sql = "DROP TABLE IF EXISTS courses;
    CREATE TABLE courses(
    id INT (11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL,
    progression VARCHAR(255) NOT NULL, 
    courseplan VARCHAR(255) NOT NULL
);";



//Skriv ut sql-frågan
echo "<pre>$sql</pre>";

//Skicka sql till DB
if($db->multi_query($sql)){
    echo "<p>Tabeller installerade.</p>";

} else{
    echo "<p class='error'>Fel vid installation av tabeller</p>";
}

?>