<?php
include_once("./database/constants.php");
if (!isset($_SESSION["userid"])) {
    header("location:" . DOMAIN . "/");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/styles.css">
    <title>Dashboard</title>
</head>

<body>

    <?php
    include_once('./templates/header.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mx-auto">
                    <img src="./images/profile.png" class="card-img-top mx-auto" style="width: 60%;" alt="Admin-Profile">
                    <div class="card-body">
                        <p class="card-title "><span style="font-size: 1,5rem;"><b>Profile Info</b></span></p>
                        <p class="card-text"><span style="font-size: 1.5rem;"><i class="fas fa-user m-right"></i><?php echo ucwords($_SESSION["username"]) ?></span></p>
                        <p class="card-text" style="font-size: 1.3rem;"><i class="fas fa-user m-right"></i>Admin</p>
                        <a href="#" class="btn btn-primary"><i class="fas fa-edit m-right"></i>Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="jumbotron" style="height: 100%; width: 100%;">
                    <h1>Welcome, <?php echo ucwords($_SESSION["username"]) ?></h1>
                    <div class="row">
                        <div class="col-sm-6">
                            <iframe src="https://free.timeanddate.com/clock/i8koxx8t/n44/szw150/szh150/hoc999/hbw0/hfcf09/cf100/hncf0f/hwcf00/fan2/fas18/facfff/fdi76/mqcfff/mqs4/mql18/mqw4/mqd60/mhcfff/mhs4/mhl5/mhw4/mhd62/mmv0/hhcfff/hhs1/hhb10/hmcfff/hms1/hmb10/hscfff/hsw3" frameborder="0" width="150" height="150"></iframe>
                        </div>
                        <div class="col-sm-6">
                            <div class="card ">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 1.5rem;"><b>New Order</b></h5>
                                    <p class="card-text" style="font-size: 1.1rem;">Here you make invoice and create new orders</p>
                                    <a href="./new_order.php" class="btn btn-primary">New Order</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.5rem;"><b>Categories</b></h5>
                        <p class="card-text" style="font-size: 1.1rem;">Here you can manage your category and add new sub-categories</p>
                        <a href="#" data-toggle="modal" data-target="#category" class="btn btn-primary"><i class="fas fa-add m-right"></i>Add</a>
                        <a href="manage_category.php" class="btn btn-primary"><i class="fas fa-edit m-right"></i>Manage</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.5rem;"><b>Brands</b></h5>
                        <p class="card-text" style="font-size: 1.1rem;">Here you can manage your Brand and add new Brand</p>
                        <a href="#" data-toggle="modal" data-target="#brand" class="btn btn-primary"><i class="fas fa-add m-right"></i>Add</a>
                        <a href="./manage_brand.php" class="btn btn-primary"><i class="fas fa-edit m-right"></i>Manage</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.5rem;"><b>Products</b></h5>
                        <p class="card-text" style="font-size: 1.1rem;">Here you can manage your Products and add new Products</p>
                        <a href="#" data-toggle="modal" data-target="#product" class="btn btn-primary"><i class="fas fa-add m-right"></i>Add</a>
                        <a href="./manage_product.php" class="btn btn-primary"><i class="fas fa-edit m-right"></i>Manage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once('./templates/category.php');
    include_once('./templates/brand.php');
    include_once('./templates/product.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="./js/main.js"></script>
</body>

</html>