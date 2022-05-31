<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require 'includes/config.php';
require 'includes/database.php';
require 'includes/classes/Course.class.php';

//Read in the method and store in a variable
$method = $_SERVER['REQUEST_METHOD'];

//If a parameter of id exists in the url, store it in a variable
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
$database = new Database();
$db= $database->connect();

//New instance of class
$course = new Course($db);


switch($method) {
    case 'GET':
        //Send HTTP response code
        http_response_code(200); //Ok - The request has succeeded
        $response= $course->getCourses();

        if(count($response) == 0){
             //Stores a message that is then sent back to the caller
            $response = array("message" => "There is nothing to get yet");

        }

        break;

    case 'POST':
        //Read in the JSON data sent with the request and store in a variable
        $data = json_decode(file_get_contents("php://input"));

        if($course->addCourse($data->name, $data->code, $data->progression, $data->courseplan)) {

            $response = array("message" => "Created");
            http_response_code(201); //Created

        }else{
            $response = array("message" => "Något gick fel, prova igen");
            http_response_code(500); //Server error
        }
        
        break;

    case 'PUT':
        //If no id is sent, send error message
        if(!isset($id)) {
            http_response_code(510);//400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "Du måste skicka med id");
        //If id is sent  
        } else {
            $data = json_decode(file_get_contents("php://input"));

          if($course->updateCourse($id, $data->name, $data->code, $data->progression, $data->coursesplan)) {
                 http_response_code(200);
            $response = array("message" => "Kurs uppdaterad");
          } else {
              http_response_code(503);
              $response = array ("message" => "Du måste skicka med id");
          }
      
        }

        break;

    case 'DELETE':
        if(!isset($id)) {
            http_response_code(510); //Not extended
            $response = array("message" => "Inget id har skickats.");
            //If id is sent
        } else {
            //Run the function to delete a row
            if($course->deleteCourse($id)) {
                http_response_code(200); //ok
                $response = array("message" => "Kursen med id: $id är raderad.");
            } else {
                http_response_code(503); //Server error
                $response = array("message" => "Kursen raderades inte, försök igen. ");
            }
        }
        break;
    }
    
//Send back the response to the caller
echo json_encode($response);