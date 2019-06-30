<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Lead.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate lead object
  $lead = new Lead($db);

  // Lead query
  $result = $lead->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any leads
  if($num > 0) {
    // Lead array
    $leads_arr = array();
    // $leads_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $lead_item = array(
        'id' => $id,
        'customer_name' => $customer_name,
        'product' => html_entity_decode($product),
        'category_id' => $category_id,
        'category_name' => $category_name
      );

      // Push to "data"
      array_push($leads_arr, $lead_item);
      // array_push($leads_arr['data'], $lead_item);
    }

    // Turn to JSON & output
    echo json_encode($leads_arr);

  } else {
    // No Leads
    echo json_encode(
      array('message' => 'No Leads Found')
    );
  }
