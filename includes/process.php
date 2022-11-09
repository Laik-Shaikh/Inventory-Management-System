<?php

use LDAP\Result;

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
$file = "{$base_dir}database{$ds}constants.php";
include_once($file);
include_once('./user.php');
include_once('./DBOperation.php');
include_once('./manage.php');

// for register
if (isset($_POST["username"]) and isset($_POST["email"])) {
	$user = new User();
	$result = $user->createUserAccount($_POST["username"], $_POST["email"], $_POST["password1"], $_POST["role"]);
	echo $result;
	exit();
}

// for login
if (isset($_POST["login_email"]) and isset($_POST["login_password"])) {
	$user = new User();
	$result = $user->userLogin($_POST["login_email"], $_POST["login_password"]);
	echo $result;
	exit();
}

//To get Category
if (isset($_POST["getCategory"])) {
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("category");
	foreach ($rows as $row) {
		echo "<option value='" . $row["cid"] . "'>" . $row["category_name"] . "</option>";
	}
	exit();
}

//Add Category
if (isset($_POST["category_name"]) and isset($_POST["parent_cat"])) {
	$obj = new DBOperation();
	$result = $obj->addCategory($_POST["parent_cat"], $_POST["category_name"]);
	echo $result;
	exit();
}

// Add brand
if (isset($_POST["brand_name"])) {
	$obj = new DBOperation();
	$result = $obj->addBrands($_POST["brand_name"]);
	echo $result;
	exit();
}

// fetch Brand 
if (isset($_POST["getBrand"])) {
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("brand");
	foreach ($rows as $row) {
		echo "<option value='" . $row["bid"] . "'>" . $row["brand_name"] . "</option>";
	}
	exit();
}

// add product 
if (isset($_POST["date"]) and isset($_POST["product_name"])) {
	$obj = new DBOperation();
	$result = $obj->addProduct(
		$_POST["product_name"],
		$_POST["date"],
		$_POST["cid"],
		$_POST["bid"],
		$_POST["price"],
		$_POST["qauntity"]
	);
	echo $result;
	exit();
}

// ---------------Manage Category--------------//

// get all category
if (isset($_POST["manageCategory"])) {
	$m = new Manage();
	$result = $m->manageRecordWithPagination("category", $_POST["pageno"]);
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	if (count($rows) > 0) {
		$n = (($_POST["pageno"] - 1) * 5) + 1;
		foreach ($rows as $row) {
?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><?php echo $row["category"]; ?></td>
				<td><?php echo $row["parent"]; ?></td>
				<td><a href="#" class="btn btn-success btn-sm">Active</a></td>
				<td>
					<a href="#" did="<?php echo $row['cid']; ?>" class="btn btn-danger btn-sm del_cat">Delete</a>
					<a href="#" eid="<?php echo $row['cid']; ?>" data-toggle="modal" data-target="#form_category" class="btn btn-info btn-sm edit_cat">Edit</a>
				</td>
			</tr>
		<?php
			$n++;
		}
		?>
		<tr>
			<td colspan="5"><?php echo $pagination; ?></td>
		</tr>
		<?php
		exit();
	}
}

// delete category
if (isset($_POST["deleteCategory"])) {
	$m = new Manage();
	$result = $m->deleteRecord("category", "cid", $_POST["id"]);
	echo $result;
}

//get single Category
if (isset($_POST["updateCategory"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("category", "cid", $_POST["id"]);
	echo json_encode($result);
	exit();
}

//Update Record after getting data
if (isset($_POST["update_category"])) {
	$m = new Manage();
	$id = $_POST["cid"];
	$name = $_POST["update_category"];
	$parent = $_POST["parent_cat"];
	$result = $m->updateRecord("category", ["cid" => $id], ["parent_cat" => $parent, "category_name" => $name, "status" => 1]);
	echo $result;
}


// ------------Manage Brands---------------//

// Get all brand 
if (isset($_POST["manageBrands"])) {
	$m = new Manage();
	$result = $m->manageRecordWithPagination("brand", $_POST["pageno"]);
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	if (count($rows) > 0) {
		$n = (($_POST["pageno"] - 1) * 5) + 1;
		foreach ($rows as $row) {
		?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><?php echo $row["brand_name"]; ?></td>
				<td><a href="#" class="btn btn-success btn-sm">Active</a></td>
				<td>
					<a href="#" did="<?php echo $row['bid']; ?>" class="btn btn-danger btn-sm del_brand">Delete</a>
					<a href="#" eid="<?php echo $row['bid']; ?>" data-toggle="modal" data-target="#form_category" class="btn btn-info btn-sm edit_brand">Edit</a>
				</td>
			</tr>
		<?php
			$n++;
		}
		?>
		<tr>
			<td colspan="5"><?php echo $pagination; ?></td>
		</tr>
		<?php
		exit();
	}
}

// delete brand
if (isset($_POST["deleteBrand"])) {
	$m = new Manage();
	$result = $m->deleteRecord("brand", "bid", $_POST["id"]);
	echo $result;
}

// get single Brand 
if (isset($_POST["updateBrand"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("brand", "bid", $_POST["id"]);
	echo json_encode($result);
	exit();
}

if (isset($_POST["update_brand"])) {
	$id = $_POST["bid"];
	$name = $_POST["update_brand"];
	$m = new Manage();
	$result = $m->updateRecord("brand", ["bid" => $id], ["brand_name" => $name, "status" => 1]);
	echo $result;
}


// --------------Products -------------//
// get all products 
if (isset($_POST["manageProducts"])) {
	$m = new Manage();
	$result = $m->manageRecordWithPagination("products", $_POST["pageno"]);
	$rows = $result["rows"];
	$pagination = $result["pagination"];
	if (count($rows) > 0) {
		$n = (($_POST["pageno"] - 1) * 5) + 1;
		foreach ($rows as $row) {
		?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><?php echo $row["product_name"]; ?></td>
				<td><?php echo $row["category_name"]; ?></td>
				<td><?php echo $row["brand_name"]; ?></td>
				<td><?php echo $row["product_price"]; ?></td>
				<td><?php echo $row["product_stock"]; ?></td>
				<td><?php echo $row["added_date"]; ?></td>
				<td><a href="#" class="btn btn-success btn-sm">Active</a></td>
				<td>
					<a href="#" did="<?php echo $row['pid']; ?>" class="btn btn-danger btn-sm del_product">Delete</a>
					<a href="#" eid="<?php echo $row['pid']; ?>" data-toggle="modal" data-target="#form_products" class="btn btn-info btn-sm edit_product">Edit</a>
				</td>
			</tr>
		<?php
			$n++;
		}
		?>
		<tr>
			<td colspan="5"><?php echo $pagination; ?></td>
		</tr>
	<?php
		exit();
	}
}

// delete Product
if (isset($_POST["deleteProduct"])) {
	$m = new Manage();
	$result = $m->deleteRecord("products", "pid", $_POST["id"]);
	echo $result;
}

// update products 
if (isset($_POST["updateProduct"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("products", 'pid', $_POST["id"]);
	echo json_encode($result);
	exit();
}

if (isset($_POST["update_product"])) {
	$m = new Manage();
	$id = $_POST["pid"];
	$name = $_POST["update_product"];
	$cat = $_POST["select_cat"];
	$brand = $_POST["select_brand"];
	$price = $_POST["product_price"];
	$qty = $_POST["product_qty"];
	$date = $_POST["added_date"];
	$result = $m->updateRecord("products", ["pid" => $id], ["cid" => $cat, "bid" => $brand, "product_name" => $name, "product_price" => $price, "product_stock" => $qty, "added_date" => $date]);
	echo $result;
}


//--------------New Order-----------//
//get new row
if (isset($_POST["getNewOrderItem"])) {
	$obj = new DBOperation();
	$rows = $obj->getAllRecord("products");
	?>
	<tr>
		<td><b class="number">1</b></td>
		<td>
			<select name="pid[]" class="form-control form-control-sm pid" required>
				<option value="">Choose Product</option>
				<?php
				foreach ($rows as $row) {
				?>
					<option value="<?php echo $row['pid']; ?>"><?php echo $row["product_name"]; ?></option>
				<?php
				}
				?>
			</select>
		</td>
		<td><input name="tqty[]" readonly type="text" class="form-control form-control-sm tqty"></td>
		<td><input name="qty[]" type="text" class="form-control form-control-sm qty" required></td>
		<td><input name="price[]" type="text" class="form-control form-control-sm price" readonly></span>
			<span><input name="pro_name[]" type="hidden" class="form-control form-control-sm pro_name">
		</td>
		<td>Rs.<span class="amt">0</span></td>
	</tr>
<?php
	exit();
}

// get price and quantiy
if (isset($_POST["getPriceAndQty"])) {
	$m = new Manage();
	$result = $m->getSingleRecord("products", "pid", $_POST["id"]);
	echo json_encode($result);
	exit();
}

// accepting order
if(isset($_POST["order_date"]) AND isset($_POST["cust_name"])) {
	$orderdate = $_POST["order_date"];
	$cust_name = $_POST["cust_name"];


	//Now getting array from order_form
	$ar_tqty = $_POST["tqty"];
	$ar_qty = $_POST["qty"];
	$ar_price = $_POST["price"];
	$ar_pro_name = $_POST["pro_name"];


	$grand_total = $_POST["grand_total"];
	$gst = $_POST["gst"];
	$discount = $_POST["discount"];
	$net_total = $_POST["net_total"];
	$paid = $_POST["paid"];
	$due = $_POST["due"];
	$payment_type = $_POST["payment_type"];

	$m = new Manage();
	echo $result = $m->storeCustomerOrderInvoice($orderdate,$cust_name,$ar_tqty,$ar_qty,$ar_price,$ar_pro_name,$grand_total,$gst,$discount,$net_total,$paid,$due,$payment_type);

}







?>