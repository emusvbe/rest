<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Lead.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $lead = new Lead($db);

  // Get ID
  $lead->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get lead
  $lead->read_single();

  // Create array
  $lead_arr = array(
    'id' => $lead->id,
    'customer_name' => $lead->customer_name,
    'product' => $lead->product,
    'category_id' => $lead->category_id,
    'category_name' => $lead->category_name,
    'created_at' => $lead->created_at
  );

  // Make JSON
  print_r(json_encode($lead_arr));