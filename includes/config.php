<?php
$devMode=true;

if($devMode){
    error_reporting(-1);
    ini_set("display_errors", 1);
}

spl_autoload_register(function($class_name){
    include 'classes/' . $class_name . '.class.php';
});

if($devMode){
    define("DBHOST", "localhost");
    define("DBUSER", "coursedb");
    define("DBPASS", "password");
    define("DBDATABASE", "coursedb");
}
else{
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "");
    define("DBPASS", "");
    define("DBDATABASE", "");
}
?>