<?php 
  class Lead {
    // DB stuff
    private $conn;
    private $table = 'leads_info';

    // Lead Properties
    public $id;
    public $category_id;
    public $category_name;
    public $customer_name;
    public $product;
	  public $created_at;
	

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Leads
    public function read() {
      // Create query
      $query = 'SELECT c.name as category_name, l.id, l.category_id, l.customer_name, l.product, l.created_at
                                FROM ' . $this->table . ' l
                                LEFT JOIN
                                  categories c ON l.category_id = c.id
                                ORDER BY
                                  l.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Lead
    public function read_single() {
          // Create query
          $query = 'SELECT c.name as category_name, l.id, l.category_id, l.customer_name, l.product, l.created_at
                                    FROM ' . $this->table . ' l
                                    LEFT JOIN
                                      categories c ON l.category_id = c.id
                                    WHERE
                                      l.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->customer_name = $row['customer_name'];
          $this->category_id = $row['category_id'];
          $this->category_name = $row['category_name'];
		      $this->product = $row['product'];
    }

    // Create Lead
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET customer_name = :customer_name, product = :product, category_id = :category_id, created_at = :created_at';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));
		      $this->product = htmlspecialchars(strip_tags($this->product));
                    

          // Bind data
          $stmt->bindParam(':customer_name', $this->customer_name);
          $stmt->bindParam(':product', $this->product);
          $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':created_at', $this->created_at);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Lead
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET customer_name = :customer_name, product = :product, category_id = :category_id, created_at = :created_at
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
          $this->product = htmlspecialchars(strip_tags($this->product));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));
          $this->created_at = htmlspecialchars(strip_tags($this->created_at));
          $this->id = htmlspecialchars(strip_tags($this->id));


          // Bind data
          $stmt->bindParam(':customer_name', $this->customer_name);
          $stmt->bindParam(':product', $this->product);
          $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':created_at', $this->created_at);
          $stmt->bindParam(':id', $this->id);
          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Lead
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }