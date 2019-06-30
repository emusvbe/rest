<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Lead.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate lead object
  $lead = new Lead($db);

  // Get raw lead data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $lead->id = $data->id;

  // Delete lead
  if($lead->delete()) {
    echo json_encode(
      array('message' => 'Lead Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Lead Not Deleted')
    );
  }

