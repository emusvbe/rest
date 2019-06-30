<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: LEAD');
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

  $lead->customer_name = $data->customer_name;
  $lead->product = $data->product;
  $lead->category_id = $data->category_id;
  $lead->category_name = $data->category_name;
  $lead->created_at = $data->created_at;

  // Create lead
  if($lead->create()) {
    echo json_encode(
      array('message' => 'Lead Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Lead Not Created')
    );
  }

