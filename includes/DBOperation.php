<?php

class DBOperation {

    private $connection;

    function __construct()
    {
        include_once('../database/db.php');
        $user = new Database();
        $this->connection = $user->connect();  
    }

    public function addCategory($parent_cat, $category_name) {
        $status = 1;
        $pre_stmt = $this->connection->prepare("INSERT INTO `category`(`parent_cat`, `category_name`, `status`) VALUES 
        (?, ?, ?)");
        $pre_stmt->bind_param('isi', $parent_cat, $category_name, $status);
        $result = $pre_stmt->execute() or die($this->connection->error);
        if($result) {
            return "CATEGORY ADDED";
        } else {
            return 0;
        }
    }

    public function getAllRecord($table){
		$pre_stmt = $this->connection->prepare("SELECT * FROM ".$table);
		$pre_stmt->execute() or die($this->connection->error);
		$result = $pre_stmt->get_result();
		$rows = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}
		return "NO_DATA";
	}

    public function addBrands($brand_name) {
        $pre_stmt = $this->connection->prepare("INSERT INTO `brand`(`brand_name`, `status`) 
        VALUES (?,?)");
        $status = 1;
        $pre_stmt->bind_param('si', $brand_name, $status);
        $result = $pre_stmt->execute() or die($this->connection->error);
        if($result) {
            return "Brand Added";
        }else {
            return 0;
        }
    }

    public function addProduct($product_name, $added_date, $cid, $bid, $price, $qantity) {
        $pre_stmt = $this->connection->prepare("INSERT INTO `products`
        (`cid`, `bid`, `product_name`, `product_price`, `product_stock`, `added_date`, `p_status`) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
        $status =1;
        $pre_stmt->bind_param('iisdisi', $cid, $bid, $product_name, $price, $qantity, $added_date, $status);
        $result = $pre_stmt->execute() or die ($this->connection->error);
        if($result) {
            return "PRODUCT ADDED";
        } else {
            return 0;
        }
    }
}


?>