<?php

include("includes/config.php");

$s = new Course();

echo "<pre>";
var_dump($s->getCourses());
echo "</pre>";